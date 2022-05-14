@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => ''])
            {{ $enquiryMessage['subject'] }}
        @endcomponent
    @endslot


Dear Reshma,<br>
	{{ $enquiryMessage['message'] }}

**With regards,**<br>
{{$enquiryMessage['fullName']}}<br>
{{$enquiryMessage['email']}}

    @slot('footer')
        @component('mail::footer')
        @endcomponent
    @endslot

@endcomponent
