#!/usr/bin/env python3
"""
批量重写 usecase 文件，确保所有链接都是绝对链接
"""
import os
from pathlib import Path

# 需要重写的文件列表和对应的标题、描述
USECASE_FILES = {
    'secure-pdf-sharing.html': {
        'title': 'Secure PDF Sharing for Business',
        'description': 'Share PDFs securely with advanced access control, encryption, and tracking features.',
        'icon': 'shield-alt'
    },
    'pdf-access-control.html': {
        'title': 'PDF Access Control & Permissions',
        'description': 'Control who can access your PDFs with advanced permission settings and restrictions.',
        'icon': 'key'
    },
    'pdf-tracking.html': {
        'title': 'PDF Tracking & Analytics',
        'description': 'Track document views, downloads, and user engagement with detailed analytics.',
        'icon': 'chart-line'
    },
    'pdf-analytics.html': {
        'title': 'PDF Analytics & Insights',
        'description': 'Gain insights into document performance with comprehensive analytics and reporting.',
        'icon': 'chart-bar'
    },
    'pdf-watermarking.html': {
        'title': 'PDF Watermarking Protection',
        'description': 'Protect your PDFs with dynamic watermarks that deter unauthorized sharing.',
        'icon': 'water'
    },
    'pdf-branding.html': {
        'title': 'PDF Branding & Customization',
        'description': 'Brand your PDFs with custom logos, colors, and professional styling.',
        'icon': 'trademark'
    },
    'pdf-encryption.html': {
        'title': 'PDF Encryption & Security',
        'description': 'Encrypt your PDFs with industry-standard encryption for maximum security.',
        'icon': 'lock'
    },
    'pdf-password-protection.html': {
        'title': 'PDF Password Protection',
        'description': 'Protect your PDFs with password authentication and access control.',
        'icon': 'key'
    },
    'pdf-expiration-dates.html': {
        'title': 'PDF Expiration & Time Limits',
        'description': 'Set expiration dates and time limits for PDF access to control document availability.',
        'icon': 'clock'
    },
    'pdf-security.html': {
        'title': 'Comprehensive PDF Security',
        'description': 'Complete PDF security solution with multiple layers of protection.',
        'icon': 'shield-alt'
    },
    'pdf-sharing-analytics.html': {
        'title': 'PDF Sharing Analytics',
        'description': 'Monitor PDF sharing patterns and track document distribution.',
        'icon': 'share-alt'
    },
    'share-pdf-online.html': {
        'title': 'Share PDF Online',
        'description': 'Share PDFs online with secure links and access control.',
        'icon': 'share-square'
    },
    'track-pdf-usage.html': {
        'title': 'Track PDF Usage & Engagement',
        'description': 'Track how your PDFs are being used and monitor viewer engagement.',
        'icon': 'eye'
    },
    'free-pdf-hosting.html': {
        'title': 'Free PDF Hosting & Storage',
        'description': 'Host and store your PDFs online for free with secure cloud storage.',
        'icon': 'cloud'
    },
    'document-control-security.html': {
        'title': 'Document Control & Security',
        'description': 'Comprehensive document control and security management system.',
        'icon': 'lock'
    }
}

def get_base_template():
    """返回基础 HTML 模板"""
    return '''<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{title} | MaiPDF</title>
    <meta name="description" content="{description}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {{
            --primary-color: #1a73e8;
            --secondary-color: #34a853;
            --text-color: #333;
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
        }}

        * {{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }}

        body {{
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
        }}

        .container {{
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }}

        header {{
            text-align: center;
            padding: 3rem 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            margin-bottom: 2rem;
        }}

        h1 {{
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }}

        .header-description {{
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }}

        .content-section {{
            background: var(--card-bg);
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }}

        h2 {{
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }}

        h3 {{
            color: var(--text-color);
            margin: 1.5rem 0 1rem;
            font-size: 1.5rem;
        }}

        .feature-grid {{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }}

        .feature-card {{
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }}

        .feature-card:hover {{
            transform: translateY(-5px);
        }}

        .feature-card h3 {{
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }}

        .feature-card i {{
            color: var(--primary-color);
        }}

        .maipdf-button {{
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem 2rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }}

        .maipdf-button:hover {{
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }}

        .warning-box {{
            background: #fce8e6;
            border-left: 4px solid #d93025;
            padding: 1.5rem;
            margin: 2rem 0;
            border-radius: 0 8px 8px 0;
        }}

        .tip-box {{
            background: #e8f0fe;
            border-left: 4px solid var(--primary-color);
            padding: 1.5rem;
            margin: 2rem 0;
            border-radius: 0 8px 8px 0;
        }}

        .workflow-container {{
            background: var(--card-bg);
            padding: 2rem;
            border-radius: 10px;
            margin: 2rem 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }}

        .workflow-step {{
            text-align: center;
            padding: 1.5rem;
        }}

        .workflow-step i {{
            color: var(--primary-color);
            margin-bottom: 1rem;
        }}

        @media (max-width: 768px) {{
            .container {{
                padding: 1rem;
            }}
            
            header {{
                padding: 2rem 1rem;
            }}

            h1 {{
                font-size: 2rem;
            }}

            .feature-grid {{
                grid-template-columns: 1fr;
            }}
        }}
    </style>

    <!-- Breadcrumb Structured Data -->
    <script type="application/ld+json">
    {{
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {{
                "@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": "https://sendpdfonline.com/"
            }},
            {{
                "@type": "ListItem",
                "position": 2,
                "name": "Usecase",
                "item": "https://sendpdfonline.com/usecase/"
            }},
            {{
                "@type": "ListItem",
                "position": 3,
                "name": "{title}",
                "item": "https://sendpdfonline.com/usecase/{filename}"
            }}
        ]
    }}
    </script>
</head>
<body>

    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" style="background-color: #f8f9fa; padding: 1rem 0;">
        <div class="container">
            <ol class="breadcrumb mb-0" style="list-style: none; display: flex; gap: 0.5rem;">
                <li class="breadcrumb-item"><a href="https://sendpdfonline.com/">Home</a></li>
                <li class="breadcrumb-item">/</li>
                <li class="breadcrumb-item"><a href="https://sendpdfonline.com/usecase/">Usecase</a></li>
                <li class="breadcrumb-item">/</li>
                <li class="breadcrumb-item active" aria-current="page">{title}</li>
            </ol>
        </div>
    </nav>
    
    <header>
        <h1><i class="fas fa-{icon}"></i> {title}</h1>
        <div class="mb-3">
            <small style="opacity: 0.9;">
                <i class="fas fa-calendar-alt"></i> Published: January 15, 2025 | 
                <i class="fas fa-sync-alt"></i> Updated: December 04, 2025
            </small>
        </div>
        <p class="header-description">{description}</p>
    </header>

    <main class="container">
        {content}
    </main>

    <div class="container">
        <div class="content-section" style="text-align: center;">
            <h2>Get Started Today</h2>
            <p>Experience the power of MaiPDF's advanced features.</p>
            <a href="https://maipdf.com" class="maipdf-button" target="_blank" rel="noopener">
                <i class="fas fa-rocket"></i> Try MaiPDF Now
            </a>
        </div>
    </div>

    <div class="container">
        <div class="content-section">
            <h2>Related Use Cases</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <h3><i class="fas fa-shield-alt"></i> <a href="https://sendpdfonline.com/usecase/secure-pdf-sharing.html">Secure PDF Sharing</a></h3>
                    <p>Learn how to share PDFs securely with advanced protection.</p>
                </div>
                <div class="feature-card">
                    <h3><i class="fas fa-chart-line"></i> <a href="https://sendpdfonline.com/usecase/pdf-tracking.html">PDF Tracking</a></h3>
                    <p>Track document access and usage analytics.</p>
                </div>
                <div class="feature-card">
                    <h3><i class="fas fa-lock"></i> <a href="https://sendpdfonline.com/usecase/document-control-security.html">Document Control</a></h3>
                    <p>Comprehensive document security management.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="content-section" style="text-align: center; margin-top: 3rem;">
        <p>&copy; 2025 MaiPDF. All rights reserved.</p>
        <div style="margin-top: 1rem;">
            <a href="https://sendpdfonline.com/usecase/" style="margin: 0 1rem; color: var(--primary-color);">Back to Use Cases</a>
            <a href="https://sendpdfonline.com/" style="margin: 0 1rem; color: var(--primary-color);">Home</a>
            <a href="https://maipdf.com" style="margin: 0 1rem; color: var(--primary-color);" target="_blank" rel="noopener">Try MaiPDF</a>
        </div>
    </footer>
</body>
</html>'''

if __name__ == '__main__':
    print("This script provides the template structure.")
    print("Files will be rewritten individually with detailed content.")

