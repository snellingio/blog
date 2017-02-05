# Pattern Parser

Recently, I published a pattern parsing library which you can find on Github (https://github.com/snellingio/pattern-parser).

Originally built as a way to start testing NLP phrases, it offers a lot of power without the complexity of regular expressions.

Say you wanted to build a slash command to `/estimate` how long a particular task would take in hours and minutes, rounded to the nearest 15 minutes.

How would you parse this?
```angular2html
/estimate 3 hrs 20 minutes
```

vs this

```angular2html
/estimate 3hours 20m
```

vs this

```
/estimate 3 h 20 min
```

Instead of writing a complex regular expression, let's just normalize the string, pattern parse, and do some math.

```php
$comment       = '/estimate 3 h 20 min';
$patternParser = new OnROI\PatternParser\PatternParser();

// Remove forward slash if someone is using /estimate
if (strpos($comment, '/') === 0) {
    $comment = substr($comment, 1);
}

// Skip comment if it doesn't have estimate starting it out
if (strpos(strtolower($comment), 'estimate') !== 0) {
    return false;
}

$clean_comment = trim(str_replace(['estimate', ':', '-', 'our', 'r', 'in', 'ute', 's'], '', strtolower($comment)));

// Parse two different scenarios, hours, and hours and minutes
$parsed_hours_minutes = $patternParser->process($clean_comment, '{hours}h {minutes}m');
$parsed_hours         = $patternParser->process($clean_comment, '{hours}h');
$parsed_minutes       = $patternParser->process($clean_comment, '{minutes}m');

// We could not parse hours, ruh roh. This should always be parsed at a minimum.
if (empty($parsed_hours) && empty($parsed_minutes)) {
    return false;
}

$hours   = 0;
$minutes = 0;

// Set estimate to parsed hours
if (!empty($parsed_hours)) {
    // Parse & filter hours
    $hours = (float) filter_var($parsed_hours['hours'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

if (!empty($parsed_minutes)) {
    // Parse & filter minutes
    $minutes = (float) filter_var($parsed_minutes['minutes'], FILTER_SANITIZE_NUMBER_INT);
}

if (!empty($parsed_hours_minutes)) {
    // Parse & filter hours and minutes
    $hours   = (float) filter_var($parsed_hours_minutes['hours'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $minutes = (int) filter_var($parsed_hours_minutes['minutes'], FILTER_SANITIZE_NUMBER_INT);
}

// Parse in 15 minute increments
$minutes_to_hours = ceil($minutes / 15) * .25;

// Set the time
$estimate = $hours + $minutes_to_hours;
```

Easy peasy.