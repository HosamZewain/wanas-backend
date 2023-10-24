<template>
    <div class="btn-group ico-dropdown lang-dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="ico ico-language"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" :class="{active: $i18n.locale==lang}" v-for="(lang, index) in availableLocales"
                :key="index" @click.prevent="changeLang(lang)">
                {{ $t(lang) }}
                <span v-if="$i18n.locale==lang" class="ico ico-check"></span>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'lang-switcher',

        data() {
            return {
                name: 'sss',
                availableLocales: this.$i18n.availableLocales,
            }
        },

        methods: {
            changeLang(lang) {
                console.log(this.name);
                Vue.$cookies.set('lang', lang);
            }
        }
    }

</script>
