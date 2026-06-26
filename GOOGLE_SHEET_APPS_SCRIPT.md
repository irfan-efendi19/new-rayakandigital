# Google Sheets Apps Script Setup

Use this Apps Script as a webhook for the `Hubungi Kami` contact form.

## 1. Create a new Google Apps Script

1. Open Google Drive.
2. Click `New` → `More` → `Google Apps Script`.
3. Replace the default code with the script below.

```javascript
function doPost(e) {
  try {
    const params = e.parameter || {};

    const timestamp = params.timestamp || new Date().toISOString();
    const name = params.name || '';
    const email = params.email || '';
    const subject = params.subject || '';
    const message = params.message || '';

    const sheet = SpreadsheetApp.openById('YOUR_SPREADSHEET_ID').getSheetByName('Sheet1');
    sheet.appendRow([timestamp, name, email, subject, message]);

    return ContentService
      .createTextOutput(JSON.stringify({ status: 'success', message: 'Data saved to Google Sheet.' }))
      .setMimeType(ContentService.MimeType.JSON);
  } catch (error) {
    return ContentService
      .createTextOutput(JSON.stringify({ status: 'error', message: error.message }))
      .setMimeType(ContentService.MimeType.JSON);
  }
}
```

## 2. Deploy as Web App

1. Click `Deploy` → `New deployment`.
2. Choose `Web app`.
3. Set `Execute as` to `Me`.
4. Set `Who has access` to `Anyone` or `Anyone with the link`.
5. Click `Deploy`.
6. Copy the deployed web app URL.

## 3. Configure your Laravel app

1. Open `.env`.
2. Set `GOOGLE_SHEET_SCRIPT_URL` to the web app URL.

Example:

```dotenv
GOOGLE_SHEET_SCRIPT_URL=https://script.google.com/macros/s/YOUR_DEPLOYMENT_ID/exec
```

## 4. Replace the sheet ID

In the script, replace `YOUR_SPREADSHEET_ID` with the ID of your Google Sheet.

The sheet ID is the long value in your sheet URL:

```
https://docs.google.com/spreadsheets/d/YOUR_SPREADSHEET_ID/edit
```

## 5. Sheet layout

Use a sheet with these columns in row 1:

- `Timestamp`
- `Name`
- `Email`
- `Subject`
- `Message`

## 6. Test

Submit the form at `/hubungi-kami` and verify the row is added to the sheet.
