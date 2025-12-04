#!/usr/bin/env python3
"""
Quick check and enhance articles that might be missing:
1. External blog reference to article.maipdf.com
2. Clear back navigation
3. Related articles section
"""

import os
import re

def check_and_enhance_article(file_path):
    """Check article and add missing enhancements."""
    
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content
    changes = []
    
    # Check if external blog reference exists
    if 'article.maipdf.com' not in content:
        # Add external blog reference before footer or end of content
        blog_reference = '''
    <!-- Related Resources -->
    <div class="container my-5">
        <div class="alert alert-info border-0 shadow-sm">
            <h4><i class="fas fa-book-open"></i> More Expert Guides & Tutorials</h4>
            <p class="mb-3">Explore in-depth articles, tutorials, and best practices on our professional blog:</p>
            <a href="https://article.maipdf.com" target="_blank" rel="noopener" class="btn btn-info">
                <i class="fas fa-external-link-alt"></i> Visit MaiPDF Expert Blog
            </a>
        </div>
    </div>
'''
        # Insert before footer or closing body tag
        if '<footer' in content:
            content = content.replace('<footer', blog_reference + '\n    <footer')
            changes.append("Added external blog reference")
        elif '</body>' in content:
            content = content.replace('</body>', blog_reference + '\n</body>')
            changes.append("Added external blog reference")
    
    # Check for back navigation
    if 'Back to Articles' not in content and '返回文章列表' not in content and 'العودة' not in content:
        # Determine language from file
        filename = os.path.basename(file_path)
        
        if '-zh.html' in filename or 'cn.html' in filename:
            # Chinese
            back_nav = '''
    <div class="container my-4 text-center">
        <a href="/article/" class="btn btn-primary me-2">
            <i class="fas fa-arrow-left"></i> 返回文章列表
        </a>
        <a href="/" class="btn btn-outline-primary me-2">
            <i class="fas fa-home"></i> 首页
        </a>
        <a href="https://maipdf.com" class="btn btn-success" target="_blank" rel="noopener">
            <i class="fas fa-rocket"></i> 立即使用
        </a>
    </div>
'''
        elif '-ar.html' in filename:
            # Arabic
            back_nav = '''
    <div class="container my-4 text-center">
        <a href="/article/" class="btn btn-primary me-2">
            <i class="fas fa-arrow-right"></i> العودة إلى المقالات
        </a>
        <a href="/" class="btn btn-outline-primary me-2">
            <i class="fas fa-home"></i> الرئيسية
        </a>
        <a href="https://maipdf.com" class="btn btn-success" target="_blank" rel="noopener">
            <i class="fas fa-rocket"></i> جرّب الآن
        </a>
    </div>
'''
        else:
            # English and others
            back_nav = '''
    <div class="container my-4 text-center">
        <a href="/article/" class="btn btn-primary me-2">
            <i class="fas fa-arrow-left"></i> Back to Articles
        </a>
        <a href="/" class="btn btn-outline-primary me-2">
            <i class="fas fa-home"></i> Home
        </a>
        <a href="https://maipdf.com" class="btn btn-success" target="_blank" rel="noopener">
            <i class="fas fa-rocket"></i> Try Now
        </a>
    </div>
'''
        
        # Insert before footer
        if '<footer' in content:
            content = content.replace('<footer', back_nav + '\n    <footer')
            changes.append("Added back navigation")
        elif '</body>' in content:
            content = content.replace('</body>', back_nav + '\n</body>')
            changes.append("Added back navigation")
    
    if content != original_content:
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(content)
        return True, changes
    
    return False, []


def main():
    """Process article files."""
    
    base_dir = '/Users/joehuang/Documents/GitHub/sendpdfonline/article'
    
    # Get all HTML files
    html_files = [f for f in os.listdir(base_dir) if f.endswith('.html') and f != 'index.html']
    
    print("🔧 Checking and enhancing article files...")
    print(f"📁 Directory: {base_dir}\n")
    
    modified_count = 0
    already_good = 0
    
    for filename in sorted(html_files):
        file_path = os.path.join(base_dir, filename)
        modified, changes = check_and_enhance_article(file_path)
        
        if modified:
            modified_count += 1
            print(f"✅ {filename}")
            for change in changes:
                print(f"   - {change}")
        else:
            already_good += 1
    
    print(f"\n📊 Summary:")
    print(f"   Total files: {len(html_files)}")
    print(f"   Modified: {modified_count}")
    print(f"   Already optimized: {already_good}")
    
    if modified_count > 0:
        print(f"\n✨ Articles enhanced successfully!")
    else:
        print(f"\n✅ All articles are already well-optimized!")


if __name__ == '__main__':
    main()
