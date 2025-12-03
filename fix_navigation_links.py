#!/usr/bin/env python3
"""
Fix navigation links across the site - convert absolute URLs to relative paths
to prevent circular navigation and improve clarity.
"""

import os
import re
from pathlib import Path

def fix_links_in_file(file_path):
    """Fix navigation links in a single HTML file."""
    
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content
    changes_made = []
    
    # Get the directory depth to calculate relative paths
    file_dir = os.path.dirname(file_path)
    depth = len(Path(file_path).relative_to('/Users/joehuang/Documents/GitHub/sendpdfonline').parts) - 1
    
    # Calculate the relative path prefix
    if depth == 0:
        prefix = ""
    else:
        prefix = "../" * depth
    
    # Pattern 1: Fix internal navigation links (href="https://sendpdfonline.com/...)
    # Replace with relative paths
    replacements = [
        # Homepage links
        (r'href="https://sendpdfonline\.com/"', 'href="/"'),
        (r'href="https://sendpdfonline\.com"', 'href="/"'),
        
        # Features links
        (r'href="https://sendpdfonline\.com/features/', f'href="{prefix}features/'),
        
        # Use cases links
        (r'href="https://sendpdfonline\.com/usecase/', f'href="{prefix}usecase/'),
        (r'href="https://sendpdfonline\.com/usecase"', f'href="{prefix}usecase/"'),
        
        # Article/blog links
        (r'href="https://sendpdfonline\.com/article/', f'href="{prefix}article/'),
        (r'href="https://sendpdfonline\.com/article"', f'href="{prefix}article/"'),
        
        # Language-specific pages (keep relative, not absolute)
        (r'href="https://sendpdfonline\.com/japanese/', f'href="{prefix}japanese/'),
        (r'href="https://sendpdfonline\.com/german/', f'href="{prefix}german/'),
        (r'href="https://sendpdfonline\.com/french/', f'href="{prefix}french/'),
        (r'href="https://sendpdfonline\.com/arabic/', f'href="{prefix}arabic/'),
        (r'href="https://sendpdfonline\.com/chinese/', f'href="{prefix}chinese/'),
        (r'href="https://sendpdfonline\.com/korean/', f'href="{prefix}korean/'),
        (r'href="https://sendpdfonline\.com/spanish/', f'href="{prefix}spanish/'),
        (r'href="https://sendpdfonline\.com/italian/', f'href="{prefix}italian/'),
        
        # Other pages
        (r'href="https://sendpdfonline\.com/convert-pdf-features\.html"', f'href="{prefix}convert-pdf-features.html"'),
        (r'href="https://sendpdfonline\.com/flipbook/', f'href="{prefix}flipbook/'),
    ]
    
    for pattern, replacement in replacements:
        matches = len(re.findall(pattern, content))
        if matches > 0:
            content = re.sub(pattern, replacement, content)
            changes_made.append(f"  - Fixed {matches} instances of {pattern}")
    
    # Special handling for canonical URLs and structured data - keep these as absolute URLs
    # (already done by not touching them)
    
    if content != original_content:
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(content)
        return True, changes_made
    
    return False, []


def main():
    """Main function to process all HTML files."""
    
    base_dir = '/Users/joehuang/Documents/GitHub/sendpdfonline'
    
    # Files to process
    files_to_process = [
        'index.html',
        'features/index.html',
    ]
    
    # Also process all feature pages
    features_dirs = [
        'features/en/security',
        'features/en/sharing',
        'features/en/hosting',
        'features/en/watermark',
        'features/en/tracking',
        'features/en/design',
        'features/en/comparison',
    ]
    
    for feature_dir in features_dirs:
        full_dir = os.path.join(base_dir, feature_dir)
        if os.path.exists(full_dir):
            for file in os.listdir(full_dir):
                if file.endswith('.html'):
                    files_to_process.append(os.path.join(feature_dir, file))
    
    total_files = 0
    modified_files = 0
    
    print("🔧 Fixing navigation links...")
    print(f"📁 Base directory: {base_dir}\n")
    
    for file_path in files_to_process:
        full_path = os.path.join(base_dir, file_path)
        
        if not os.path.exists(full_path):
            continue
        
        total_files += 1
        modified, changes = fix_links_in_file(full_path)
        
        if modified:
            modified_files += 1
            print(f"✅ {file_path}")
            for change in changes:
                print(change)
            print()
    
    print(f"\n📊 Summary:")
    print(f"   Total files processed: {total_files}")
    print(f"   Files modified: {modified_files}")
    print(f"   Files unchanged: {total_files - modified_files}")
    print(f"\n✨ Navigation links fixed successfully!")
    print(f"\n💡 Next steps:")
    print(f"   1. Review the changes: git diff")
    print(f"   2. Test the navigation flow")
    print(f"   3. Commit changes: git commit -am 'Fix navigation links'")


if __name__ == '__main__':
    main()
