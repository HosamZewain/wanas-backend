<script>
export default {
    name: "filters",
    emits: ["submit"],
    props: {
        model: {
            type: [Array, Object],
        },
        enableKeyword: {
            type: Boolean,
            default: true,
        },
        enableSubmit: {
            type: Boolean,
            default: true,
        },
        keyword: {
            type: String,
            default: "global.search",
        },
    },
    methods: {
        submit() {
            this.$emit("submit");
        },
    },
};
</script>

<template>
    <form class="white-form" @keydown.enter.prevent="submit">
        <div class="align-items-end row">
            <div class="col-md-3" v-if="enableKeyword">
                <div class="mb-3">
                    <el-form-item
                        label="search"
                        class="mb-0"
                    >
                    </el-form-item>
                    <el-input
                        v-model="model['keyword']"
                        :placeholder="$t(keyword)"
                        clearable
                    />
                </div>
            </div>
            <slot></slot>
            <div class="col-md-3">
                <el-button
                    type="primary"
                    class="btn btn-primary mb-3"
                    @click.prevent="submit"
                    >{{ $t("global.search") }}</el-button
                >
            </div>
        </div>
    </form>
</template>
