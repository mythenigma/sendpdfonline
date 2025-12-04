#!/usr/bin/env python3
"""
Optimize Arabic language pages with SEO enhancements:
- Add breadcrumb navigation
- Add publication dates
- Add back navigation
- Fix internal links
"""

import os
import re
from datetime import datetime

def optimize_arabic_page(file_path):
    """Add SEO enhancements to Arabic page."""
    
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content
    changes = []
    
    # Get filename for breadcrumb
    filename = os.path.basename(file_path)
    page_name = filename.replace('.html', '').replace('-', ' ').title()
    
    # Add breadcrumb after header (after first </header> or first .header closing div)
    breadcrumb_html = '''
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="container mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="/arabic/">العربية</a></li>
            <li class="breadcrumb-item active" aria-current="page">''' + page_name + '''</li>
        </ol>
    </nav>
    
    <!-- Publication Date -->
    <div class="container">
        <p class="text-muted small mb-3">
            <i class="fas fa-calendar-alt"></i> آخر تحديث: 3 ديسمبر 2025
            | <i class="fas fa-clock"></i> وقت القراءة: 5-7 دقائق
        </p>
    </div>
'''
    
    # Try to insert after header section
    if '</header>' in content:
        content = content.replace('</header>', '</header>\n' + breadcrumb_html)
        changes.append("Added breadcrumb after header")
    elif '<div class="header">' in content and content.count('</div>') > 0:
        # Find the closing div of header
        header_start = content.find('<div class="header">')
        header_section = content[header_start:]
        first_close_div = header_section.find('</div>') + len('</div>')
        insert_pos = header_start + first_close_div
        content = content[:insert_pos] + '\n' + breadcrumb_html + content[insert_pos:]
        changes.append("Added breadcrumb after header div")
    
    # Add back navigation button before footer or at end of content-wrapper
    back_nav_html = '''
    <!-- Back Navigation -->
    <div class="container my-4">
        <div class="text-center">
            <a href="/arabic/" class="btn btn-primary me-2">
                <i class="fas fa-arrow-right"></i> العودة إلى الفهرس
            </a>
            <a href="/" class="btn btn-outline-primary me-2">
                <i class="fas fa-home"></i> الصفحة الرئيسية
            </a>
            <a href="https://maipdf.com" class="btn btn-success" target="_blank" rel="noopener">
                <i class="fas fa-upload"></i> جرّب الآن
            </a>
        </div>
    </div>
'''
    
    # Insert before footer or before closing body tag
    if '<footer' in content:
        content = content.replace('<footer', back_nav_html + '\n    <footer')
        changes.append("Added back navigation before footer")
    elif '</body>' in content:
        content = content.replace('</body>', back_nav_html + '\n</body>')
        changes.append("Added back navigation before body close")
    
    # Add external blog reference
    blog_reference = '''
    <!-- External Resources -->
    <div class="container my-4">
        <div class="alert alert-info">
            <h5><i class="fas fa-book-open"></i> موارد إضافية</h5>
            <p class="mb-2">للحصول على أدلة ودروس متعمقة، قم بزيارة:</p>
            <a href="https://article.maipdf.com" target="_blank" rel="noopener" class="btn btn-sm btn-outline-info">
                <i class="fas fa-external-link-alt"></i> مدونة MaiPDF الاحترافية
            </a>
        </div>
    </div>
'''
    
    # Insert external resources before back navigation
    if back_nav_html in content:
        content = content.replace(back_nav_html, blog_reference + '\n' + back_nav_html)
        changes.append("Added external blog reference")
    
    # Fix internal links to use relative paths
    content = re.sub(r'href="https://sendpdfonline\.com/arabic/', 'href="/arabic/', content)
    content = re.sub(r'href="https://sendpdfonline\.com/', 'href="/', content)
    
    if content != original_content:
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(content)
        return True, changes
    
    return False, []


def main():
    """Process all Arabic HTML files."""
    
    base_dir = '/Users/joehuang/Documents/GitHub/sendpdfonline/arabic'
    
    # Get all HTML files except index.html
    html_files = [f for f in os.listdir(base_dir) 
                  if f.endswith('.html') and f != 'index.html']
    
    print("🔧 Optimizing Arabic language pages...")
    print(f"📁 Directory: {base_dir}\n")
    
    modified_count = 0
    
    for filename in sorted(html_files):
        file_path = os.path.join(base_dir, filename)
        modified, changes = optimize_arabic_page(file_path)
        
        if modified:
            modified_count += 1
            print(f"✅ {filename}")
            for change in changes:
                print(f"   - {change}")
            print()
    
    print(f"\n📊 Summary:")
    print(f"   Total files: {len(html_files)}")
    print(f"   Modified: {modified_count}")
    print(f"   Unchanged: {len(html_files) - modified_count}")
    print(f"\n✨ Arabic pages optimized successfully!")
    print(f"\n💡 Enhancements added:")
    print(f"   - Breadcrumb navigation (SEO)")
    print(f"   - Publication dates")
    print(f"   - Back navigation buttons")
    print(f"   - External blog references")
    print(f"   - Fixed internal links")


if __name__ == '__main__':
    main()
