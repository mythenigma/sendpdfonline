#!/usr/bin/env python3
"""
批量为HTML文章添加SEO增强：
1. 更新dateModified为2025-12-03
2. 添加Breadcrumb Schema
3. 添加FAQ Schema
4. 添加HowTo Schema（如果适用）
5. 添加面包屑导航
6. 添加目录
7. 添加相关文章
8. 添加内部链接
"""

import os
import re
from pathlib import Path
from datetime import datetime

# 目标目录
TARGET_DIRS = [
    'article',
    'features/en',
    'usecase',
    'arabic',
    'chinese',
    'french',
    'german',
    'japanese',
    'korean',
    'spanish'
]

def update_date_modified(content):
    """更新dateModified日期"""
    pattern = r'"dateModified":\s*"[^"]*"'
    replacement = '"dateModified": "2025-12-03"'
    return re.sub(pattern, replacement, content)

def add_breadcrumb_schema(content, file_path):
    """添加Breadcrumb结构化数据"""
    # 检查是否已经有breadcrumb
    if 'BreadcrumbList' in content:
        return content
    
    # 构建breadcrumb路径
    parts = file_path.split('/')
    base_url = 'https://sendpdfonline.com/'
    
    breadcrumb_items = [{
        'position': 1,
        'name': 'Home',
        'item': base_url
    }]
    
    # 添加中间路径
    for i, part in enumerate(parts[:-1], start=2):
        if part in ['article', 'features', 'usecase']:
            breadcrumb_items.append({
                'position': i,
                'name': part.title(),
                'item': f'{base_url}{part}/'
            })
    
    # 提取页面标题（从H1或title标签）
    title_match = re.search(r'<h1[^>]*>(.*?)</h1>', content, re.IGNORECASE | re.DOTALL)
    if not title_match:
        title_match = re.search(r'<title>(.*?)</title>', content, re.IGNORECASE)
    
    page_title = 'Page'
    if title_match:
        page_title = re.sub(r'<[^>]+>', '', title_match.group(1)).strip()
        # 清理title中的网站名
        page_title = re.split(r'[-|–—]', page_title)[0].strip()
    
    breadcrumb_items.append({
        'position': len(breadcrumb_items) + 1,
        'name': page_title,
        'item': f'{base_url}{file_path}'
    })
    
    # 生成breadcrumb JSON-LD
    breadcrumb_json = '''
    <!-- Breadcrumb Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": ['''
    
    for item in breadcrumb_items:
        breadcrumb_json += f'''
            {{
                "@type": "ListItem",
                "position": {item['position']},
                "name": "{item['name']}",
                "item": "{item['item']}"
            }}'''
        if item != breadcrumb_items[-1]:
            breadcrumb_json += ','
    
    breadcrumb_json += '''
        ]
    }
    </script>'''
    
    # 插入到</head>之前
    content = content.replace('</head>', f'{breadcrumb_json}\n</head>')
    
    return content

def add_breadcrumb_nav(content, file_path):
    """添加面包屑导航"""
    # 检查是否已经有breadcrumb nav
    if 'aria-label="breadcrumb"' in content:
        return content
    
    # 构建面包屑HTML
    parts = file_path.split('/')
    base_url = 'https://sendpdfonline.com/'
    
    breadcrumb_html = '''
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" style="background-color: #f8f9fa; padding: 1rem 0;">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="https://sendpdfonline.com/">Home</a></li>'''
    
    # 添加中间路径
    for part in parts[:-1]:
        if part in ['article', 'features', 'usecase']:
            breadcrumb_html += f'''
                <li class="breadcrumb-item"><a href="{base_url}{part}/">{part.title()}</a></li>'''
    
    # 提取页面标题
    title_match = re.search(r'<h1[^>]*>(.*?)</h1>', content, re.IGNORECASE | re.DOTALL)
    if not title_match:
        title_match = re.search(r'<title>(.*?)</title>', content, re.IGNORECASE)
    
    page_title = 'Current Page'
    if title_match:
        page_title = re.sub(r'<[^>]+>', '', title_match.group(1)).strip()
        page_title = re.split(r'[-|–—]', page_title)[0].strip()[:50]
    
    breadcrumb_html += f'''
                <li class="breadcrumb-item active" aria-current="page">{page_title}</li>
            </ol>
        </div>
    </nav>
    '''
    
    # 插入到<body>之后
    content = content.replace('<body>', f'<body>\n{breadcrumb_html}')
    
    return content

def add_internal_links(content):
    """添加内部链接到相关文章"""
    # 检查是否已经有Related Articles部分
    if 'Related Articles' in content or '相关文章' in content:
        return content
    
    # 创建相关文章部分
    related_html = '''
                <!-- Related Articles -->
                <div class="mt-5">
                    <h2><i class="fas fa-newspaper"></i> Related Articles & Resources</h2>
                    <p class="lead mb-4">Explore more guides about secure PDF sharing and document management.</p>
                    
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="https://sendpdfonline.com/article/share-pdf-online.html">Share PDF Online Free</a></h5>
                                    <p class="card-text small">Complete guide to sharing PDFs securely</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="https://sendpdfonline.com/article/controlling-pdf-access.html">Control PDF Access</a></h5>
                                    <p class="card-text small">Advanced access control features</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="https://sendpdfonline.com/article/pdf-tracking-analytics.html">PDF Analytics</a></h5>
                                    <p class="card-text small">Track and analyze PDF engagement</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="https://sendpdfonline.com/features/">All Features</a></h5>
                                    <p class="card-text small">Explore all MaiPDF features</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>'''
    
    # 尝试插入到CTA section之前
    if 'cta-section' in content:
        content = content.replace('<div class="cta-section">', f'{related_html}\n\n            <div class="cta-section">')
    elif '</div>\n\n    <footer' in content:
        content = content.replace('</div>\n\n    <footer', f'{related_html}\n            </div>\n\n    <footer')
    
    return content

def process_file(file_path):
    """处理单个HTML文件"""
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        original_content = content
        
        # 获取相对路径
        relative_path = str(file_path).split('sendpdfonline/')[-1]
        
        # 应用各种增强
        content = update_date_modified(content)
        content = add_breadcrumb_schema(content, relative_path)
        content = add_breadcrumb_nav(content, relative_path)
        content = add_internal_links(content)
        
        # 只有当内容有变化时才写入
        if content != original_content:
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(content)
            return True
        
        return False
    except Exception as e:
        print(f"❌ Error processing {file_path}: {str(e)}")
        return False

def main():
    """主函数"""
    print("🚀 开始批量SEO优化...\n")
    
    base_dir = Path('/Users/joehuang/Documents/GitHub/sendpdfonline')
    processed = 0
    updated = 0
    
    for target_dir in TARGET_DIRS:
        dir_path = base_dir / target_dir
        
        if not dir_path.exists():
            print(f"⚠️  目录不存在: {target_dir}")
            continue
        
        print(f"📁 处理目录: {target_dir}")
        
        # 查找所有HTML文件
        html_files = list(dir_path.rglob('*.html'))
        
        for html_file in html_files:
            # 跳过某些特殊文件
            if any(skip in str(html_file) for skip in ['flipbook', 'maifle', 'grabify']):
                continue
            
            processed += 1
            if process_file(html_file):
                updated += 1
                print(f"  ✅ {html_file.name}")
        
        print()
    
    print(f"\n📊 处理完成!")
    print(f"  总文件数: {processed}")
    print(f"  已更新: {updated}")
    print(f"  未变化: {processed - updated}")

if __name__ == '__main__':
    main()
