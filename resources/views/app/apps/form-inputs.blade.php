@php $editing = isset($apps) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="title" label="Title" :value="old('title', $editing ? $apps->title : '')" maxlength="255" placeholder="Title"
            required></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div x-data="imageViewer('{{ $editing && $apps->image ? \Storage::url($apps->image) : '' }}')">
            <x-inputs.partials.label name="image" label="Image"></x-inputs.partials.label><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img :src="imageUrl" class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;" />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div class="border rounded border-gray-200 bg-gray-100" style="width: 100px; height: 100px;"></div>
            </template>

            <div class="mt-2">
                <input type="file" name="image" id="image" @change="fileChosen" />
            </div>

            @error('image')
                @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="description" label="Description" maxlength="255"
            required>{{ old('description', $editing ? $apps->description : '') }}</x-inputs.textarea>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="type" label="Type" :value="old('type', $editing ? $apps->type : '')" maxlength="255" placeholder="Type"
            required></x-inputs.text>
    </x-inputs.group>
</div>
