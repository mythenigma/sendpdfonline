#!/usr/bin/env python3
"""
批量替换 article.maipdf.com 外链为本站链接
"""
import os
import re
from pathlib import Path

# 外链映射到本站链接
LINK_MAPPING = {
    'https://article.maipdf.com/pdf-security-best-practices/': '/features/en/security/pdf-security-best-practices.html',
    'https://article.maipdf.com/document-watermarking-guide/': '/new-articles-for-blog/document-watermarking-guide.html',
    'https://article.maipdf.com/pdf-analytics-tracking/': '/new-articles-for-blog/pdf-analytics-tracking.html',
}

def fix_external_links(file_path):
    """替换文件中的外链"""
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        original_content = content
        
        # 替换每个外链
        for external_link, internal_link in LINK_MAPPING.items():
            # 替换 href 中的链接
            content = content.replace(
                f'href="{external_link}"',
                f'href="{internal_link}"'
            )
            # 也替换可能没有引号的情况
            content = content.replace(external_link, internal_link)
        
        # 如果内容有变化，写回文件
        if content != original_content:
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(content)
            return True
        return False
    except Exception as e:
        print(f"Error processing {file_path}: {e}")
        return False

def main():
    """主函数"""
    base_dir = Path(__file__).parent
    
    # 需要处理的目录
    directories = [
        'article',
        'usecase',
        'features',
    ]
    
    total_files = 0
    modified_files = 0
    
    for directory in directories:
        dir_path = base_dir / directory
        if not dir_path.exists():
            continue
        
        # 遍历所有 HTML 文件
        for html_file in dir_path.rglob('*.html'):
            total_files += 1
            if fix_external_links(html_file):
                modified_files += 1
                print(f"✓ Fixed: {html_file.relative_to(base_dir)}")
    
    print(f"\n处理完成: 共检查 {total_files} 个文件，修改了 {modified_files} 个文件")

if __name__ == '__main__':
    main()


