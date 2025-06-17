<template>
    <!-- Gouden border effect -->
    <div class="flex h-[25px] w-full bg-[#ff0000]">
        <div class="w-[7px]"></div>
        <div class="w-[25px] border-t-[4px] border-l-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-t-[4px] border-r-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-r-[4px] border-b-[4px] border-[#ffff00]"></div>
        <div class="flex-1 border-t-[4px] border-b-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-b-[4px] border-l-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-t-[4px] border-l-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-t-[4px] border-r-[4px] border-[#ffff00]"></div>
        <div class="w-[7px]"></div>
    </div>

    <!-- Tweede border -->
    <div class="flex h-[25px] w-full bg-[#ff0000]">
        <div class="w-[7px]"></div>
        <div class="w-[25px] border-b-[4px] border-l-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-[4px] border-t-0 border-l-0 border-[#ffff00]"></div>
        <div class="flex-1"></div>
        <div class="w-[25px] border-[4px] border-t-0 border-r-0 border-[#ffff00]"></div>
        <div class="w-[25px] border-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-r-[4px] border-b-[4px] border-[#ffff00]"></div>
        <div class="w-[7px]"></div>
    </div>

    <!-- Derde border -->
    <div class="flex h-[25px] w-full bg-[#ff0000]">
        <div class="w-[7px]"></div>
        <div class="w-[25px] border-r-[4px] border-b-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-[4px] border-t-0 border-l-0 border-[#ffff00]"></div>
        <div class="w-[25px]"></div>
        <div class="flex-1"></div>
        <div class="w-[25px]"></div>
        <div class="w-[25px] border-[4px] border-t-0 border-[#ffff00]"></div>
        <div class="w-[25px] border-b-[4px] border-[#ffff00]"></div>
        <div class="w-[7px]"></div>
    </div>

    <!-- Main content -->
    <div class="flex w-full bg-[#ff0000]">
        <div class="w-[7px]"></div>
        <div class="w-[25px] border-r-[4px] border-l-[4px] border-[#ffff00]"></div>
        <div class="w-[25px]"></div>
        <div class="w-[25px]"></div>
        <div class="flex flex-1 flex-col">
            <slot />
        </div>
        <div class="w-[25px]"></div>
        <div class="w-[25px]"></div>
        <div class="w-[25px] border-r-[4px] border-l-[4px] border-[#ffff00]"></div>
        <div class="w-[7px]"></div>
    </div>

    <!-- Onderste borders -->
    <div class="flex h-[25px] w-full bg-[#ff0000]">
        <div class="w-[7px]"></div>
        <div class="w-[25px] border-t-[4px] border-r-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-[4px] border-b-0 border-l-0 border-[#ffff00]"></div>
        <div class="w-[25px]"></div>
        <div class="flex-1"></div>
        <div class="w-[25px]"></div>
        <div class="w-[25px] border-[4px] border-b-0 border-[#ffff00]"></div>
        <div class="w-[25px] border-t-[4px] border-[#ffff00]"></div>
        <div class="w-[7px]"></div>
    </div>

    <div class="flex h-[25px] w-full bg-[#ff0000]">
        <div class="w-[7px]"></div>
        <div class="w-[25px] border-t-[4px] border-l-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-[4px] border-l-0 border-[#ffff00]"></div>
        <div class="flex-1"></div>
        <div class="w-[25px] border-[4px] border-r-0 border-[#ffff00]"></div>
        <div class="w-[25px] border-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-t-[4px] border-r-[4px] border-[#ffff00]"></div>
        <div class="w-[7px]"></div>
    </div>

    <div class="flex h-[25px] w-full bg-[#ff0000]">
        <div class="w-[7px]"></div>
        <div class="w-[25px] border-b-[4px] border-l-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-r-[4px] border-b-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-r-[4px] border-[#ffff00]"></div>
        <div class="flex-1 border-t-[4px] border-b-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-l-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-b-[4px] border-l-[4px] border-[#ffff00]"></div>
        <div class="w-[25px] border-r-[4px] border-b-[4px] border-[#ffff00]"></div>
        <div class="w-[7px]"></div>
    </div>

    <div class="h-[7px] w-full bg-[#ff0000]"></div>
</template>
