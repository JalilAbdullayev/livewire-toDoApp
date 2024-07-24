<div id="content" class="mx-auto" style="max-width:500px;">
    @include('livewire.includes.create-to-do-box')
    @include('livewire.includes.search-box')
    <div id="todos-list">
        @foreach($todos as $todo)
            @include('livewire.includes.to-do-card')
        @endforeach

        <div class="my-2">
            {{ $todos->links() }}
        </div>
    </div>
</div>
