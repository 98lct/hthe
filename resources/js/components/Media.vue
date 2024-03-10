<template>
    <div class="border-b " v-if="medias != null && (medias).length > 0" uk-lightbox>
        <!--SINGLE-->
        <div v-if="(medias).length == 1" class="p-5">
            <a v-if="(medias).length == 1 && medias[0]['type'] == 'image'"
                :href="'/' + this.$store.getters.mediaPath + '/' + medias[0]['src']">
                <img :src="'/' + this.$store.getters.mediaPath + '/' + medias[0]['src']" alt=""
                    class="max-h-96 w-full object-cover">
            </a>
            <iframe v-else :src="'/' + this.$store.getters.mediaPath + '/' + medias[0]['src']"
                frameborder="0" uk-video="automute: false" allowfullscreen uk-responsive
                class="rounded-md w-full lg:h-76 object-cover"></iframe>
        </div>
        <!--DOUBLE-->
        <div v-if="(medias).length == 2" class="grid grid-cols-2 gap-2 p-5">
            <div>
                <a v-if="medias[0]['type'] == 'image'"
                    :href="'/' + this.$store.getters.mediaPath + '/' + medias[0]['src']">
                    <img :src="'/' + this.$store.getters.mediaPath + '/' + medias[0]['src']" alt=""
                        class="rounded-md w-full lg:h-76 object-cover">
                </a>
                <iframe v-else :src="'/' + this.$store.getters.mediaPath + '/' + medias[0]['src']"
                    frameborder="0" uk-video="automute: false" allowfullscreen uk-responsive
                    class="rounded-md w-full lg:h-76 h-full object-cover"></iframe>
            </div>
            <div>
                <a v-if="medias[1]['type'] == 'image'"
                    :href="'/' + this.$store.getters.mediaPath + '/' + medias[1]['src']">
                    <img :src="'/' + this.$store.getters.mediaPath + '/' + medias[1]['src']" alt=""
                        class="rounded-md w-full lg:h-76 h-full object-cover">
                </a>
                <iframe v-else :src="'/' + this.$store.getters.mediaPath + '/' + medias[1]['src']"
                    frameborder="0" uk-video="automute: false" allowfullscreen uk-responsive
                    class="rounded-md w-full lg:h-76 h-full object-cover"></iframe>
            </div>
        </div>
        <!--OTHER-->
        <div v-if="(medias).length > 2" class="grid grid-cols-2 gap-2 p-5">
            <!-- <span> -->
            <a v-if="medias[0]['type'] == 'image'"
                :href="'/' + this.$store.getters.mediaPath + '/' + medias[0]['src']" class="col-span-2">
                <img :src="'/' + this.$store.getters.mediaPath + '/' + medias[0]['src']" alt=""
                    class="rounded-md max-h-96 w-full object-cover">
            </a>
            <iframe v-else :src="'/' + this.$store.getters.mediaPath + '/' + medias[0]['src']"
                frameborder="0" uk-video="automute: false" allowfullscreen uk-responsive
                class="rounded-md w-full lg:h-76 object-cover"></iframe>
            <!-- </span> -->

            <div>
                <a v-if="medias[1]['type'] == 'image'"
                    :href="'/' + this.$store.getters.mediaPath + '/' + medias[1]['src']">
                    <img :src="'/' + this.$store.getters.mediaPath + '/' + medias[1]['src']" alt=""
                        class="rounded-md w-full h-full object-cover">
                </a>
                <iframe v-else :src="'/' + this.$store.getters.mediaPath + '/' + medias[1]['src']"
                    frameborder="0" uk-video="automute: false" allowfullscreen uk-responsive
                    class="rounded-md w-full lg:h-76 object-cover"></iframe>
            </div>

            <div>
                <a v-if="medias[2]['type'] == 'image'"
                    :href="'/' + this.$store.getters.mediaPath + '/' + medias[2]['src']" class="relative">
                    <img :src="'/' + this.$store.getters.mediaPath + '/' + medias[2]['src']" alt=""
                        class="rounded-md w-full h-full object-cover">
                    <div
                        class="absolute bg-gray-900 bg-opacity-30 flex justify-center items-center text-white rounded-md inset-0 text-2xl">
                        + 2 more </div>
                </a>
                <iframe v-else :src="'/' + this.$store.getters.mediaPath + '/' + medias[2]['src']"
                    frameborder="0" uk-video="automute: false" allowfullscreen uk-responsive
                    class="rounded-md w-full lg:h-76 object-cover"></iframe>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['medias'],
    mounted() {
    },
}
</script>