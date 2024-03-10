<template>
<div class="main_content">
    <div class="mcontainer">
        <div class="bg-white lg:py-8 lg:px-20 flex-1 space-y-4 p-6">

            <div class="line">
                <input class="line__input" autocomplete="off" type="text" onkeyup="this.setAttribute('value', this.value);" value="">
                <span for="username" class="line__placeholder"> First Name </span>
            </div>
            <div class="line">
                <input class="line__input" autocomplete="off" type="text" onkeyup="this.setAttribute('value', this.value);" value="">
                <span for="username" class="line__placeholder"> Last Name </span>
            </div>
            <div class="line">
                <input class="line__input" autocomplete="off" name="text" type="text" onkeyup="this.setAttribute('value', this.value);" value="">
                <span for="username" class="line__placeholder"> Full Name </span>
            </div>
            <div class="line">
                <input class="line__input" autocomplete="off" name="text" type="number" onkeyup="this.setAttribute('value', this.value);" value="">
                <span for="username" class="line__placeholder"> Phone </span>
            </div>
            <div class="line">
                <input class="line__input" autocomplete="off" name="text" type="text" onkeyup="this.setAttribute('value', this.value);" value="">
                <span for="username" class="line__placeholder"> Username </span>
            </div>
            <div class="line">
                <input class="line__input" autocomplete="off" type="text" onkeyup="this.setAttribute('value', this.value);" value="">
                <span for="username" class="line__placeholder">Email </span>
            </div>
            <div class="line h-32">
                <textarea class="line__input h-32" autocomplete="off" type="text" onkeyup="this.setAttribute('value', this.value);" value=""></textarea>
                <span for="username" class="line__placeholder">Introduce </span>
            </div>
            <div class="line">
                <input class="line__input" autocomplete="off" type="text" onkeyup="this.setAttribute('value', this.value);" value="">
                <span for="username" class="line__placeholder">Live at </span>
            </div>
            <div class="line">
                <input class="line__input" autocomplete="off" type="text" onkeyup="this.setAttribute('value', this.value);" value="">
                <span for="username" class="line__placeholder">Work at </span>
            </div>
            <div class="line">
                <input class="line__input" autocomplete="off" type="text" onkeyup="this.setAttribute('value', this.value);" value="">
                <span for="username" class="line__placeholder">Learn at </span>
            </div>
            <div class="line">
                <input class="line__input" autocomplete="off" type="text" onkeyup="this.setAttribute('value', this.value);" value="">
                <span for="username" class="line__placeholder">Birth at </span>
            </div>
            <div>
                <label for=""> Relationship </label>
                <div class="">
                    <select class="with-border">
                        <option value="1">In a relationship</option>
                        <option value="2">In a love</option>
                        <option value="3">Married</option>
                        <option value="4">Widow</option>
                        <option value="5">not Published</option>
                    </select></div>
            </div>
            <div>
                <label for="">Gender </label>
                <div class="">
                    <select class="with-border">
                        <option value="0">Men</option>
                        <option value="1">Women</option>
                        <option value="2">not Published</option>
                    </select></div>
            </div>
        </div>
    </div>
</div>
</template>
