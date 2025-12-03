#!/usr/bin/env python3
"""
批量为文章添加：
1. 可见的发布/更新日期
2. article.maipdf.com 外链引用
3. 增加页面新鲜感和外部链接价值
"""

import re
from pathlib import Path
from datetime import datetime

def add_visible_dates(content, file_path):
    """在页面顶部添加可见的日期"""
    
    # 如果已经有日期显示，跳过
    if 'Published:' in content or '发布日期' in content:
        return content
    
    # 提取Schema中的日期
    published_match = re.search(r'"datePublished":\s*"([^"]+)"', content)
    modified_match = re.search(r'"dateModified":\s*"([^"]+)"', content)
    
    published_date = published_match.group(1) if published_match else "2025-01-15"
    modified_date = modified_match.group(1) if modified_match else "2025-12-03"
    
    # 转换日期格式
    try:
        pub_dt = datetime.strptime(published_date, "%Y-%m-%d")
        mod_dt = datetime.strptime(modified_date, "%Y-%m-%d")
        pub_formatted = pub_dt.strftime("%B %d, %Y")
        mod_formatted = mod_dt.strftime("%B %d, %Y")
    except:
        pub_formatted = "January 15, 2025"
        mod_formatted = "December 3, 2025"
    
    # 构建日期显示HTML
    date_html = f'''
                <!-- Publication Date -->
                <div class="mb-3">
                    <small class="text-muted">
                        <i class="fas fa-calendar-alt"></i> Published: {pub_formatted} | 
                        <i class="fas fa-sync-alt"></i> Updated: {mod_formatted}
                    </small>
                </div>
                '''
    
    # 在H1标题后插入
    h1_pattern = r'(<h1[^>]*>.*?</h1>)'
    if re.search(h1_pattern, content, re.DOTALL):
        content = re.sub(
            h1_pattern,
            r'\1' + date_html,
            content,
            count=1,
            flags=re.DOTALL
        )
    
    return content

def add_external_blog_links(content):
    """添加article.maipdf.com外链引用"""
    
    # 如果已经有外链，跳过
    if 'article.maipdf.com' in content:
        return content
    
    # 外链模块HTML
    external_links_html = '''
                <!-- External Resources from article.maipdf.com -->
                <div class="mt-5 p-4 bg-light rounded">
                    <h3><i class="fas fa-external-link-alt"></i> More Resources from MaiPDF Blog</h3>
                    <p class="mb-4">Discover more in-depth guides and tutorials on our official blog at <a href="https://article.maipdf.com" target="_blank" rel="noopener">article.maipdf.com</a></p>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card h-100 border-primary">
                                <div class="card-body">
                                    <span class="badge bg-primary mb-2">Blog Post</span>
                                    <h5 class="card-title"><a href="https://article.maipdf.com/pdf-security-best-practices/" target="_blank" rel="noopener">PDF Security Best Practices 2025</a></h5>
                                    <p class="card-text small">Complete guide to protecting your PDFs with latest security techniques.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-primary">
                                <div class="card-body">
                                    <span class="badge bg-primary mb-2">Blog Post</span>
                                    <h5 class="card-title"><a href="https://article.maipdf.com/document-watermarking-guide/" target="_blank" rel="noopener">Watermarking Complete Guide</a></h5>
                                    <p class="card-text small">Learn how dynamic watermarks protect intellectual property.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-primary">
                                <div class="card-body">
                                    <span class="badge bg-primary mb-2">Blog Post</span>
                                    <h5 class="card-title"><a href="https://article.maipdf.com/pdf-analytics-tracking/" target="_blank" rel="noopener">PDF Analytics & Tracking</a></h5>
                                    <p class="card-text small">Leverage PDF analytics to improve engagement and close deals.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
'''
    
    # 在CTA section之前插入
    if '<div class="cta-section">' in content:
        content = content.replace(
            '<div class="cta-section">',
            external_links_html + '\n            <div class="cta-section">'
        )
    elif '</div>\n\n    <footer' in content:
        content = content.replace(
            '</div>\n\n    <footer',
            external_links_html + '\n            </div>\n\n    <footer'
        )
    
    return content

def process_file(file_path):
    """处理单个文件"""
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        original = content
        
        # 应用优化
        content = add_visible_dates(content, file_path)
        content = add_external_blog_links(content)
        
        if content != original:
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(content)
            return True
        
        return False
        
    except Exception as e:
        print(f"  ❌ 错误: {str(e)}")
        return False

def main():
    print("📅 开始添加日期和外链...\n")
    
    base_dir = Path('/Users/joehuang/Documents/GitHub/sendpdfonline')
    
    # 目标目录
    target_dirs = [
        'article',
        'features/en/security',
        'features/en/sharing',
        'features/en/tracking',
        'features/en/hosting',
        'usecase',
    ]
    
    total = 0
    updated = 0
    
    for target_dir in target_dirs:
        dir_path = base_dir / target_dir
        
        if not dir_path.exists():
            continue
        
        print(f"📁 {target_dir}")
        
        # 处理HTML文件
        for html_file in dir_path.glob('*.html'):
            total += 1
            if process_file(html_file):
                updated += 1
                print(f"  ✅ {html_file.name}")
        
        print()
    
    print(f"📊 完成!")
    print(f"  总文件: {total}")
    print(f"  已更新: {updated}")
    print(f"\n💡 优化效果:")
    print(f"  - 显示新鲜日期（增加用户信任）")
    print(f"  - article.maipdf.com外链（互相支持SEO）")
    print(f"  - 增加页面权威性")

if __name__ == '__main__':
    main()
