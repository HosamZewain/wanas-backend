<template>
    <div class="mb-3">
        <el-form-item :label="$t(props.label)" class="mb-0"> </el-form-item>

        <el-date-picker
            v-model="props.model[name]"
            type="date"
            :placeholder="$t(props.label)"
            :default-value="new Date()"
            :value-format="'YYYY-MM-DD HH:mm:ss'"
        />
        <form-validation-errors :errors="props.errors" :name="props.name" />
    </div>
</template>
<script setup>
const props = defineProps({
    label: {
        type: String,
        default: "",
    },
    model: {
        type: [Array, Object],
    },
    name: {
        type: String,
        default: "",
    },
    errors: {
        type: [Array, Object],
        default: [],
    },
});
</script>

