#!/usr/bin/env python3
"""
网站链接爬虫测试工具
测试所有链接是否有效，识别会跳转回首页的无效链接
"""
import os
import re
import time
import requests
from urllib.parse import urljoin, urlparse
from bs4 import BeautifulSoup
from collections import defaultdict
import json

class WebsiteCrawler:
    def __init__(self, base_url="https://sendpdfonline.com"):
        self.base_url = base_url
        self.visited = set()
        self.broken_links = []
        self.redirects_to_home = []
        self.valid_links = []
        self.link_map = defaultdict(list)  # 记录哪些页面链接到某个URL
        self.session = requests.Session()
        self.session.headers.update({
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        })
        self.timeout = 10
        
    def is_same_domain(self, url):
        """检查URL是否属于同一域名"""
        parsed = urlparse(url)
        base_parsed = urlparse(self.base_url)
        return parsed.netloc == base_parsed.netloc or parsed.netloc == ''
    
    def normalize_url(self, url):
        """规范化URL"""
        if not url:
            return None
        
        # 处理相对路径
        if url.startswith('/'):
            url = urljoin(self.base_url, url)
        elif not url.startswith('http'):
            return None
        
        # 移除fragment
        if '#' in url:
            url = url.split('#')[0]
        
        # 移除末尾的斜杠（除了根路径）
        if url.endswith('/') and url != self.base_url + '/':
            url = url.rstrip('/')
        
        return url
    
    def check_link(self, url, referer=None):
        """检查单个链接"""
        try:
            response = self.session.get(url, timeout=self.timeout, allow_redirects=True)
            
            final_url = response.url
            
            # 检查是否重定向到首页
            if final_url == self.base_url + '/' or final_url == self.base_url:
                if url != self.base_url + '/' and url != self.base_url:
                    return {
                        'status': 'redirects_to_home',
                        'url': url,
                        'final_url': final_url,
                        'status_code': response.status_code,
                        'referer': referer
                    }
            
            # 检查状态码
            if response.status_code >= 400:
                return {
                    'status': 'broken',
                    'url': url,
                    'status_code': response.status_code,
                    'referer': referer
                }
            
            # 检查内容是否包含首页特征（可能是404页面重定向到首页）
            if response.status_code == 200:
                content = response.text.lower()
                # 如果URL不是首页，但内容看起来像首页，可能是问题
                if url != self.base_url + '/' and url != self.base_url:
                    if 'maipdf' in content and len(content) < 5000:
                        # 检查是否是简单的重定向页面
                        if 'redirect' in content or 'location.href' in content:
                            return {
                                'status': 'suspicious_redirect',
                                'url': url,
                                'status_code': response.status_code,
                                'referer': referer
                            }
            
            return {
                'status': 'valid',
                'url': url,
                'status_code': response.status_code,
                'referer': referer
            }
            
        except requests.exceptions.Timeout:
            return {
                'status': 'timeout',
                'url': url,
                'referer': referer
            }
        except requests.exceptions.RequestException as e:
            return {
                'status': 'error',
                'url': url,
                'error': str(e),
                'referer': referer
            }
    
    def extract_links(self, html, current_url):
        """从HTML中提取所有链接"""
        soup = BeautifulSoup(html, 'html.parser')
        links = set()
        
        # 提取所有a标签的href
        for tag in soup.find_all('a', href=True):
            href = tag['href']
            normalized = self.normalize_url(href)
            if normalized and self.is_same_domain(normalized):
                links.add(normalized)
        
        return links
    
    def crawl(self, start_url=None, max_pages=100):
        """开始爬取"""
        if start_url is None:
            start_url = self.base_url + '/'
        
        to_visit = [start_url]
        page_count = 0
        
        print(f"开始爬取网站: {self.base_url}")
        print(f"起始URL: {start_url}")
        print("-" * 80)
        
        while to_visit and page_count < max_pages:
            url = to_visit.pop(0)
            
            if url in self.visited:
                continue
            
            self.visited.add(url)
            page_count += 1
            
            print(f"[{page_count}] 检查: {url}")
            
            try:
                response = self.session.get(url, timeout=self.timeout, allow_redirects=True)
                
                if response.status_code == 200:
                    # 提取链接
                    links = self.extract_links(response.text, url)
                    
                    # 测试每个链接
                    for link in links:
                        if link not in self.visited:
                            result = self.check_link(link, referer=url)
                            
                            if result['status'] == 'valid':
                                self.valid_links.append(result)
                                if link not in self.visited and link.startswith(self.base_url):
                                    to_visit.append(link)
                            elif result['status'] == 'redirects_to_home':
                                self.redirects_to_home.append(result)
                                self.link_map[link].append(url)
                            elif result['status'] in ['broken', 'error', 'timeout', 'suspicious_redirect']:
                                self.broken_links.append(result)
                                self.link_map[link].append(url)
                            
                            time.sleep(0.5)  # 避免请求过快
                
            except Exception as e:
                print(f"  错误: {e}")
                self.broken_links.append({
                    'status': 'error',
                    'url': url,
                    'error': str(e)
                })
            
            time.sleep(1)  # 页面间延迟
        
        print("\n" + "=" * 80)
        print("爬取完成!")
    
    def generate_report(self):
        """生成报告"""
        report = {
            'summary': {
                'total_pages_visited': len(self.visited),
                'total_valid_links': len(self.valid_links),
                'total_broken_links': len(self.broken_links),
                'total_redirects_to_home': len(self.redirects_to_home)
            },
            'redirects_to_home': self.redirects_to_home,
            'broken_links': self.broken_links,
            'link_map': dict(self.link_map)
        }
        
        # 打印报告
        print("\n" + "=" * 80)
        print("测试报告")
        print("=" * 80)
        print(f"已访问页面数: {len(self.visited)}")
        print(f"有效链接数: {len(self.valid_links)}")
        print(f"损坏链接数: {len(self.broken_links)}")
        print(f"跳转回首页的链接数: {len(self.redirects_to_home)}")
        
        if self.redirects_to_home:
            print("\n" + "-" * 80)
            print("⚠️  跳转回首页的链接 (需要修复):")
            print("-" * 80)
            for item in self.redirects_to_home:
                print(f"\n链接: {item['url']}")
                print(f"  状态码: {item.get('status_code', 'N/A')}")
                if item.get('referer'):
                    print(f"  来源页面: {item['referer']}")
                if item['url'] in self.link_map:
                    print(f"  被以下页面链接: {', '.join(self.link_map[item['url']][:3])}")
        
        if self.broken_links:
            print("\n" + "-" * 80)
            print("❌ 损坏的链接:")
            print("-" * 80)
            for item in self.broken_links[:20]:  # 只显示前20个
                print(f"\n链接: {item['url']}")
                print(f"  状态: {item['status']}")
                if item.get('status_code'):
                    print(f"  状态码: {item['status_code']}")
                if item.get('error'):
                    print(f"  错误: {item['error']}")
                if item.get('referer'):
                    print(f"  来源页面: {item['referer']}")
        
        # 保存到文件
        with open('link_test_report.json', 'w', encoding='utf-8') as f:
            json.dump(report, f, indent=2, ensure_ascii=False)
        
        # 保存文本报告
        with open('link_test_report.txt', 'w', encoding='utf-8') as f:
            f.write("网站链接测试报告\n")
            f.write("=" * 80 + "\n\n")
            f.write(f"测试时间: {time.strftime('%Y-%m-%d %H:%M:%S')}\n")
            f.write(f"已访问页面数: {len(self.visited)}\n")
            f.write(f"有效链接数: {len(self.valid_links)}\n")
            f.write(f"损坏链接数: {len(self.broken_links)}\n")
            f.write(f"跳转回首页的链接数: {len(self.redirects_to_home)}\n\n")
            
            if self.redirects_to_home:
                f.write("\n跳转回首页的链接:\n")
                f.write("-" * 80 + "\n")
                for item in self.redirects_to_home:
                    f.write(f"\n链接: {item['url']}\n")
                    if item.get('referer'):
                        f.write(f"来源页面: {item['referer']}\n")
                    if item['url'] in self.link_map:
                        f.write(f"被以下页面链接: {', '.join(self.link_map[item['url']])}\n")
            
            if self.broken_links:
                f.write("\n损坏的链接:\n")
                f.write("-" * 80 + "\n")
                for item in self.broken_links:
                    f.write(f"\n链接: {item['url']}\n")
                    f.write(f"状态: {item['status']}\n")
                    if item.get('referer'):
                        f.write(f"来源页面: {item['referer']}\n")
        
        print(f"\n报告已保存到: link_test_report.json 和 link_test_report.txt")
        
        return report

def main():
    crawler = WebsiteCrawler()
    
    # 从首页开始爬取
    crawler.crawl(max_pages=50)  # 限制爬取页面数，避免时间过长
    
    # 生成报告
    report = crawler.generate_report()
    
    return report

if __name__ == '__main__':
    main()

