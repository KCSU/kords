<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
	<div class="row">
		<div class="col-md-12">
            <strong>Filename:</strong> {{ $entry->filename }} <br/>
            <strong>Room:</strong> {{ $entry->room->number }} <br/>
            <strong>Uploaded by:</strong>
            {{ $entry->user->name ?? 'Admin' }} at {{ $entry->created_at->format('d M Y, H:i') }} <br/>
            <img src="{{ $entry->filename }}" height="300"/>
        </div>
    </div>
</div>
<div class="clearfix"></div>