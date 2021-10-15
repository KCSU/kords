<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
	<div class="row">
		<div class="col-md-12">
            <h5>
                {{ $entry->number }}
                @if($entry->available)
                    <span class="badge badge-success">Available</span>
                @else
                    <span class="badge badge-danger">Unavailable</span>
                @endif
            </h5>
            <em>
                {{ $entry->location->name }}, Floor {{ $entry->floor }}
            </em> <br/>
            Available on <strong>
                @if ($entry->long_contract)
                    Long or Short
                @else
                    Short
                @endif
            </strong> contract. <br/>
            Band {{ $entry->band->number }}: <strong>
                {{ $entry->band->short_rent }}/{{ $entry->band->long_rent }}
            </strong> <br/>
            Key features:
            <strong>
                {{
                    $entry->perks->pluck('display_name')->implode(', ')
                }}
            </strong> <br/>
            <em>{{ $entry->notes }}</em>
        </div>
    </div>
</div>
<div class="clearfix"></div>