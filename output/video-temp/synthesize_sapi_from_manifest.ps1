param(
  [Parameter(Mandatory = $true)]
  [string]$ManifestPath
)

$jobs = Get-Content -LiteralPath $ManifestPath -Raw -Encoding UTF8 | ConvertFrom-Json

$voice = New-Object -ComObject SAPI.SpVoice
$stream = New-Object -ComObject SAPI.SpFileStream
$voices = $voice.GetVoices()

foreach ($job in $jobs) {
  $match = $null
  for ($i = 0; $i -lt $voices.Count; $i++) {
    $candidate = $voices.Item($i)
    if ($candidate.GetDescription() -like "*$($job.voice)*") {
      $match = $candidate
      break
    }
  }

  if ($null -eq $match) {
    throw "Voice not found: $($job.voice)"
  }

  $text = Get-Content -LiteralPath $job.textFile -Raw -Encoding UTF8
  $parent = Split-Path -Parent $job.outputFile
  if (-not (Test-Path -LiteralPath $parent)) {
    New-Item -ItemType Directory -Force -Path $parent | Out-Null
  }

  $voice.Voice = $match
  $voice.Rate = [int]$job.rate
  $stream.Open($job.outputFile, 3, $false)
  $voice.AudioOutputStream = $stream
  $null = $voice.Speak($text)
  $stream.Close()
}
