# Debugging Guide

## Viewing Logs

The module now includes comprehensive logging to help diagnose issues with the Thoughts API.

### Where to Find Logs

**Joomla 5 Log Location:**
```
administrator/logs/mod_thoughtoftd.php
```

### Viewing Logs

#### Method 1: Joomla Administrator

1. Log into Joomla Administrator
2. Go to **System → Manage → System Information**
3. Click on the **Log Files** tab
4. Look for `mod_thoughtoftd.php`
5. Click to view the log

#### Method 2: Direct File Access

```bash
# View the log file
tail -f administrator/logs/mod_thoughtoftd.php

# Or view last 50 lines
tail -n 50 administrator/logs/mod_thoughtoftd.php

# Search for errors
grep ERROR administrator/logs/mod_thoughtoftd.php
```

### What Gets Logged

The module logs the following information:

#### 1. Request Information
```
Thought of the Day - Request URL: https://thoughts.brahmakumaris.org/totd?orgIds=2&lang=en...
```

#### 2. Fetch Status
```
Fetching thought from URL: https://...
```

#### 3. Raw Response (first 500 chars)
```
Raw response: {"statusCode":0,"text":"Today's thought...","topic":"Peace"}
```

#### 4. Response Type
```
Thought of the Day - Response type: object
```

#### 5. Parsed Response
```
Thought of the Day - Response data: {"statusCode":0,"text":"...","topic":"..."}
```

#### 6. Errors
```
Failed to fetch thought: Connection timeout
JSON decode error: Syntax error
Exception occurred retrieving the thought for today: ...
```

### Common Issues and Solutions

#### Issue 1: "Failed to fetch thought: Connection timeout"

**Cause:** Network connectivity issue or API is down

**Solutions:**
- Check your internet connection
- Verify the Base URL is correct
- Try accessing the URL directly in a browser
- Check if `allow_url_fopen` is enabled in PHP

```bash
# Check PHP setting
php -i | grep allow_url_fopen
```

#### Issue 2: "JSON decode error: Syntax error"

**Cause:** API returned invalid JSON

**Solutions:**
- Check the raw response in the logs
- Verify the API URL is correct
- Contact API provider if response format changed

#### Issue 3: "Response is not an object"

**Cause:** API returned `false`, `null`, or unexpected data type

**Solutions:**
- Check previous log entries for fetch errors
- Verify API is responding correctly
- Check if API requires authentication

#### Issue 4: Empty response or statusCode != 0

**Cause:** API returned error response

**Solutions:**
- Check the response data in logs
- Verify Organisation ID is correct
- Verify language code is valid
- Check date format parameters

### Testing the API Manually

#### Using curl:
```bash
curl "https://thoughts.brahmakumaris.org/totd?orgIds=2&lang=en&dateFormat=ISO8601&specificDay=false"
```

#### Using browser:
```
https://thoughts.brahmakumaris.org/totd?orgIds=2&lang=en&dateFormat=ISO8601&specificDay=false
```

#### Expected Response:
```json
{
  "statusCode": 0,
  "text": "Rather than disliking someone who insults you...",
  "topic": "Peace of Mind",
  "image": "https://example.com/image.jpg"
}
```

### Module Parameters to Check

1. **Base URL** (default: `https://thoughts.brahmakumaris.org/`)
   - Must end with `/` if using default path
   - Or include full path like `https://thoughts.brahmakumaris.org/thoughts`

2. **Organisation ID** (default: `2`)
   - Comma-separated list: `2,3,4`
   - Must be valid organisation IDs

3. **Language** (default: `en`)
   - Two-letter language code
   - Must be supported by the API

4. **For this day** (default: `false`)
   - `true`: Get thought for current day
   - `false`: Get random thought

5. **Default text**
   - Fallback message when API fails
   - Should always be configured

### Enabling Debug Mode

For more detailed debugging, enable Joomla's debug mode:

1. Go to **System → Global Configuration**
2. Click **System** tab
3. Set **Debug System** to **Yes**
4. Set **Error Reporting** to **Maximum**
5. Save

This will show PHP errors and warnings on the page.

### Disabling Logging

To disable the debug logging after troubleshooting, comment out the logging lines in:

**`mod_thoughtoftd.php`** (lines 26-34):
```php
// Debug logging
// use Joomla\CMS\Log\Log;
// Log::add('Thought of the Day - Request URL: ' . $url, Log::INFO, 'mod_thoughtoftd');
// ... etc
```

**`Helper/ThoughtoftdHelper.php`** (lines 17-30):
```php
// Log::add('Fetching thought from URL: ' . $url, Log::INFO, 'mod_thoughtoftd');
// ... etc
```

Or create a module parameter to enable/disable logging.

### Log Rotation

Joomla automatically rotates log files. Old logs are kept with timestamps:
```
mod_thoughtoftd.php
mod_thoughtoftd.php.1
mod_thoughtoftd.php.2
```

### Getting Help

When reporting issues, include:
1. Relevant log entries
2. Module configuration (parameters)
3. Joomla version
4. PHP version
5. Error messages from browser console (F12)

### Performance Note

Logging adds minimal overhead, but for production sites with high traffic, consider:
- Only logging errors (remove INFO level logs)
- Using Joomla's built-in caching
- Setting appropriate cache time in module settings

---

**Pro Tip:** Keep logging enabled for the first few days after installation to ensure everything is working correctly, then disable INFO level logging and keep only ERROR logging for production.

