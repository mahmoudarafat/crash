<div>
    <div class="row">

        @foreach ($posts as $post)
            <div wire:key="{{ $post->id }}" class="col-sm-3">
                <div class="bg-info">
                    <div class="well">
                        <h3 class="text-primary">{{ $post->title }}</h3>
                        <h5>{{ $post->author }}</h5>
                        <p>{{ $post->content }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
