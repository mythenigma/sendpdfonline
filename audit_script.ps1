$basePath = "C:\Users\chanz\Documents\GitHub\sendpdfonline"
$files = Get-ChildItem -Path $basePath -Filter "*.html" -Recurse

$results = @()

foreach ($file in $files) {
    $relPath = $file.FullName.Replace($basePath + "\", "").Replace("\", "/")
    $sizeKB = [math]::Round($file.Length / 1024, 1)
    
    if ($file.Length -eq 0) {
        $results += [PSCustomObject]@{
            Path = $relPath
            SizeKB = 0
            Noindex = "EMPTY"
            Lang = "N/A"
            Title = "EMPTY FILE"
            HasImages = $false
            HasSVG = $false
            HasMermaid = $false
            HasStructuredData = $false
            InternalLinks = 0
            DesignStyle = "N/A"
            Quality = 0
        }
        continue
    }
    
    try {
        $content = Get-Content $file.FullName -Raw -ErrorAction Stop
    } catch {
        $results += [PSCustomObject]@{
            Path = $relPath
            SizeKB = $sizeKB
            Noindex = "ERROR"
            Lang = "N/A"
            Title = "READ ERROR"
            HasImages = $false
            HasSVG = $false
            HasMermaid = $false
            HasStructuredData = $false
            InternalLinks = 0
            DesignStyle = "N/A"
            Quality = 0
        }
        continue
    }
    
    # Check noindex
    $noindex = $false
    if ($content -match 'name\s*=\s*"robots"\s+content\s*=\s*"noindex' -or $content -match 'content\s*=\s*"noindex[^"]*"\s+name\s*=\s*"robots"') {
        $noindex = $true
    }
    
    # Get language from html tag
    $lang = "EN"
    if ($content -match '<html[^>]*lang\s*=\s*"([^"]*)"') {
        $langAttr = $Matches[1].ToLower()
        if ($langAttr -match "zh|cn") { $lang = "ZH" }
        elseif ($langAttr -match "ar") { $lang = "AR" }
        elseif ($langAttr -match "de") { $lang = "DE" }
        elseif ($langAttr -match "fr") { $lang = "FR" }
        elseif ($langAttr -match "ja") { $lang = "JA" }
        elseif ($langAttr -match "ko") { $lang = "KO" }
        elseif ($langAttr -match "es") { $lang = "ES" }
        elseif ($langAttr -match "en") { $lang = "EN" }
        else { $lang = $langAttr.ToUpper() }
    } else {
        # Check content for Chinese characters to detect language
        $chineseChars = [regex]::Matches($content, '[\u4e00-\u9fff]').Count
        if ($chineseChars -gt 50) { $lang = "ZH" }
        elseif ($relPath -match "arabic/|_ar\.|_ar-") { $lang = "AR" }
        elseif ($relPath -match "german/|_de\.|_de-") { $lang = "DE" }
        elseif ($relPath -match "french/|_fr\.|_fr-") { $lang = "FR" }
        elseif ($relPath -match "japanese/|_ja\.|_ja-") { $lang = "JA" }
        elseif ($relPath -match "korean/|_ko\.|_ko-") { $lang = "KO" }
    }
    
    # Get title
    $title = "NO TITLE"
    if ($content -match '<title[^>]*>(.*?)</title>') {
        $title = $Matches[1].Trim()
        if ($title.Length -gt 80) { $title = $title.Substring(0, 77) + "..." }
    }
    
    # Check for images
    $hasImages = ($content -match '<img\s' -or $content -match 'background-image')
    
    # Check for SVG
    $hasSVG = ($content -match '<svg[\s>]')
    
    # Check for Mermaid
    $hasMermaid = ($content -match 'mermaid' -or $content -match 'class="mermaid"')
    
    # Check for structured data (JSON-LD or microdata)
    $hasStructuredData = ($content -match 'application/ld\+json' -or $content -match 'itemtype\s*=')
    
    # Count internal links
    $internalLinks = ([regex]::Matches($content, '<a\s[^>]*href\s*=\s*"(?!https?://|mailto:|tel:|#|javascript:)[^"]*"')).Count
    
    # Design style detection
    $designStyle = "outdated"
    $hasModernCSS = ($content -match 'linear-gradient|grid|flexbox|display:\s*flex|display:\s*grid|var\(--' -or 
                     $content -match 'border-radius|box-shadow|transition|animation|transform' -or
                     $content -match 'styles\.css')
    $hasBootstrap = ($content -match 'bootstrap')
    $hasTailwind = ($content -match 'tailwind')
    $hasInlineModern = ($content -match 'background:\s*(linear-gradient|radial-gradient)')
    
    if ($hasTailwind -or ($hasModernCSS -and $hasInlineModern)) {
        $designStyle = "modern"
    } elseif ($hasModernCSS -and $hasBootstrap) {
        $designStyle = "mixed"
    } elseif ($hasModernCSS) {
        $designStyle = "modern"
    } elseif ($hasBootstrap) {
        $designStyle = "mixed"
    }
    
    # Quality scoring
    $quality = 1
    if ($sizeKB -ge 5) { $quality = 2 }
    if ($sizeKB -ge 10 -and ($hasImages -or $hasSVG)) { $quality = 3 }
    if ($sizeKB -ge 15 -and $hasImages -and $hasStructuredData) { $quality = 4 }
    if ($sizeKB -ge 20 -and $hasImages -and $hasStructuredData -and ($hasSVG -or $hasMermaid) -and $designStyle -eq "modern") { $quality = 5 }
    # Also boost quality for very content-rich pages
    if ($sizeKB -ge 30 -and $hasStructuredData -and $designStyle -eq "modern") { 
        if ($quality -lt 4) { $quality = 4 } 
    }
    
    $results += [PSCustomObject]@{
        Path = $relPath
        SizeKB = $sizeKB
        Noindex = if ($noindex) { "YES" } else { "NO" }
        Lang = $lang
        Title = $title
        HasImages = $hasImages
        HasSVG = $hasSVG
        HasMermaid = $hasMermaid
        HasStructuredData = $hasStructuredData
        InternalLinks = $internalLinks
        DesignStyle = $designStyle
        Quality = $quality
    }
}

# Output as CSV for easy processing
$results | Export-Csv -Path "$basePath\audit_results.csv" -NoTypeInformation -Encoding UTF8

# Summary
$indexable = $results | Where-Object { $_.Noindex -eq "NO" -and $_.SizeKB -gt 0 }
$noindexed = $results | Where-Object { $_.Noindex -eq "YES" }
$empty = $results | Where-Object { $_.SizeKB -eq 0 -or $_.Noindex -eq "EMPTY" }

Write-Host "=== AUDIT SUMMARY ==="
Write-Host "Total HTML files: $($results.Count)"
Write-Host "Indexable (no noindex): $($indexable.Count)"
Write-Host "Noindexed: $($noindexed.Count)"
Write-Host "Empty/Error: $($empty.Count)"
Write-Host ""

# Language breakdown for indexable
Write-Host "=== LANGUAGE BREAKDOWN (Indexable) ==="
$indexable | Group-Object Lang | Sort-Object Count -Descending | ForEach-Object {
    Write-Host "$($_.Name): $($_.Count)"
}
Write-Host ""

# Quality distribution for indexable
Write-Host "=== QUALITY DISTRIBUTION (Indexable) ==="
$indexable | Group-Object Quality | Sort-Object Name | ForEach-Object {
    $stars = "*" * [int]$_.Name
    Write-Host "$stars : $($_.Count)"
}

Write-Host ""
Write-Host "CSV saved to audit_results.csv"
