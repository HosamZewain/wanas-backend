<template>
    <div class="mb-3">
        <el-form-item :label="$t(props.label)" class="mb-0"> </el-form-item>

        <el-time-select
            :start="props.start"
            :end="props.end"
            :placeholder="$t(props.label)"
            value-format="HH:mm"
            v-model="props.model[name]"
            @keydown.stop="clearError"
            @change="clearError"
        >
        </el-time-select>

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
    start: {
        type: String,
        default: "00:00",
    },
    end: {
        type: String,
        default: "23:45",
    },
    errors: {
        type: [Array, Object],
        default: [],
    },
});
</script>
