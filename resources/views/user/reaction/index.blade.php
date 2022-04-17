@foreach($reaction_types as $key => $record)
<form action="" method="POST">
    <?php $id = $idea->id; ?>
    <input type="hidden" value="{{ $id }}">
    <?php
        $reactions = App\Models\Reaction::where('type_id', $record->id)
        ->where('idea_id', $idea->id)
        ->where('user_id', Auth::user()->id)->first();
        $count_reactions = App\Models\Reaction::where('type_id', $record->id)
        ->where('idea_id', $idea->id)->get();
        if($reactions)
        { 
    ?>
            <button class="btn btn-outline-primary active" id="btn-reaction" data-idea="{{ $idea->id }}" data-type="{{ $record->reaction_type }}" data-id="{{ $record->id }}">
                <span class="{{ $record->reaction_type }}-count">
                    @if($count_reactions)
                    {{ $count_reactions->count() }}
                    @else
                    {{ $reactions->count() }}
                    @endif
                </span> 
                @if ($record->reaction_type == 'Like')
                <i class="fas fa-thumbs-up fa-2x" style="color: green;"></i>
                @elseif ($record->reaction_type == 'DisLike')
                <i class="fas fa-thumbs-down fa-2x" style="color: red;"></i>
                @else
                <span>{{ $record->reaction_type }}</span>
                @endif
            </button>
    <?php    
        }else { ?>
            <button class="btn btn-outline-primary" id="btn-reaction-new" data-idea="{{ $idea->id }}" data-type="{{ $record->reaction_type }}" data-id="{{ $record->id }}">
                <span class="{{ $record->reaction_type }}-count-new">
                    @if($count_reactions)
                    {{ $count_reactions->count() }}
                    @else
                    0
                    @endif
                </span> 
                @if ($record->reaction_type == 'Like')
                <i class="fas fa-thumbs-up fa-2x" style="color: green;"></i>
                @elseif ($record->reaction_type == 'DisLike')
                <i class="fas fa-thumbs-down fa-2x" style="color: red;"></i>
                @else
                <span>{{ $record->reaction_type }}</span>
                @endif
            </button>
    <?php    
        }
    ?>
</form>
@endforeach