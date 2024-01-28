<div>

    <div class="well">

        <div class="row">
            <div class="col-sm-12">
                <h4>Add New Post</h4>
            </div>
        </div>
        {{-- Care about people's approval and you will be their prisoner. --}}
        <form wire:submit.prevent="save">
            <div class="row form-group">
                <label class="col-sm-1" for="title">Title:</label>
                <input class="col-sm-4 form-control" type="text" id="title" wire:model="title">
                        @error('title') <span>{{ $message }}</span> @enderror

            </div>
            <div class="row form-group">
                <label class="col-sm-1" for="author">Author:</label>
                <input class="col-sm-4 form-control" type="text" id="author" wire:model="author">
                     @error('author') <span>{{ $message }}</span> @enderror
            </div>
            <div class="row form-group">
                <label class="col-sm-1" for="content">Content:</label>
                <textarea class="col-sm-4 form-control" id="content" wire:model="content"></textarea>
                        @error('content') <span>{{ $message }}</span> @enderror

            </div>
            <button type="submit">Save</button>
        </form>
    </div>

</div>
