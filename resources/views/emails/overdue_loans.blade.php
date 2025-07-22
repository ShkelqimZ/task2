<p>Dear {{ $member->name }},</p>

<p>You have the following overdue books:</p>

<ul>
@foreach ($loans as $loan)
    <li>{{ $loan->book->title }} - Due: {{ $loan->due_at }}</li>
@endforeach
</ul>

<p>Please return them as soon as possible.</p>

<p>Thank you,<br>Library Team</p>
