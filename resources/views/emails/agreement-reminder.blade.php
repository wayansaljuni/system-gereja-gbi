<x-mail::message>
# Agreement Reminder

**{{ $reminderTitle }}**

<table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
    <tr>
        <td style="width: 160px; padding: 6px 12px 6px 0; font-weight: bold; vertical-align: top;">Agreement Number</td>
        <td style="padding: 6px 0;">{{ $agreementNumber }}</td>
    </tr>
    <tr>
        <td style="width: 160px; padding: 6px 12px 6px 0; font-weight: bold; vertical-align: top;">Document Name</td>
        <td style="padding: 6px 0;">{{ $documentName }}</td>
    </tr>
    <tr>
        <td style="width: 160px; padding: 6px 12px 6px 0; font-weight: bold; vertical-align: top;">Reminder Date</td>
        <td style="padding: 6px 0;">{{ $remindAt }}</td>
    </tr>
</table>

@if($message)
---

{{ $message }}
<br>
@endif

@if($documentNotes)
<b>Notes :</b><br>

{{ $documentNotes }}
@endif

<x-mail::button :url="config('app.url')">
Open Agreement System
</x-mail::button>

This email is generated automatically by System,<br>
Terimakasih.
<br>
{{ config('app.name') }}
</x-mail::message>