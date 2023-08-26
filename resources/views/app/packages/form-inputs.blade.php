@php $editing = isset($package) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $package->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="price"
            label="Price"
            :value="old('price', ($editing ? $package->price : ''))"
            maxlength="255"
            placeholder="Price"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="month"
            label="Month"
            :value="old('month', ($editing ? $package->month : ''))"
            maxlength="255"
            placeholder="Month"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="speed"
            label="Speed"
            :value="old('speed', ($editing ? $package->speed : ''))"
            maxlength="255"
            placeholder="Speed"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            required
            >{{ old('description', ($editing ? $package->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
