<x-mail::message>
# Verification Code

Use the code below to verify that this account belongs to you.

<div style="box-sizing: border-box; letter-spacing: .8rem; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #2d3748; border-bottom: 8px solid #2d3748; border-left: 18px solid #2d3748; border-right: 18px solid #2d3748; border-top: 8px solid #2d3748;">{{ $data->verification_code }}</div>
<br />
<br/>
Ignore this message if you do not want to reset verify.
<br />
<hr />
Thank You <br />
{{ config('app.name') }}<br />
</x-mail::message>
