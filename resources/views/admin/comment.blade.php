<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
	<div class="row">
		<div class="col-md-12">
            <strong>Posted by:</strong> {{ $entry->user->name }} <br/>
            <strong>Room:</strong> {{ $entry->room->number }} <br/>
            {{-- Is this a security risk? --}}
            <strong>Content:</strong> {!! nl2br(e($entry->text)) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>