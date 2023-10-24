<template>
    <div class="mb-3">
        <el-form-item
            :label="$t(props.title)"
            class="mb-0"
            prop="name"
            :required="required"
        >
            <small v-if="hint" :class="hintClass"> {{ hintText }}</small>
        </el-form-item>
        <el-select
            v-model="props.model[name]"
            :filterable="true"
            :clearable="clearable"
            :disabled="props.disabled"
            :multiple="props.multiple"
            collapse-tags
            collapse-tags-tooltip
            :placeholder="placeholder ? placeholder : $t('forms.select')"
            @change="change"
            @removeTag="onRemoveTag"
            @clear="clear"
            @blur="blur"
        >
            <el-option
                v-for="item in props.options"
                :key="item.id"
                :label="item[label]"
                :value="item[value]"
            >
                <span style="float: left">{{ item[label] }}</span>
                <slot name="option_badge" :item="item"></slot>
            </el-option>
        </el-select>
        <form-validation-errors
            :errors="props.errors"
            :name="errorsName !== '' ? errorsName : props.name"
        />
    </div>
</template>
<script setup>
const emit = defineEmits([
    "change",
    "onRemoveTag",
    "onAddTag",
    "clear",
    "blur",
]);
const props = defineProps({
    hint:{
        type: Boolean,
        default: false,
    },
    hintClass:{
        type: String,
        default: "",
    },
    hintText:{
        type: String,
        default: "",
    },
    clearable: {
        type: Boolean,
        default: true,
    },
    title: {
        type: String,
        default: "",
    },
    label: {
        type: String,
        default: "",
    },
    value: {
        type: String,
        default: "id",
    },
    model: {
        type: [Array, Object, String],
    },
    name: {
        type: [Number, String],
        default: "",
    },
    placeholder: {
        type: String,
        default: "",
    },
    errors: {
        type: [Array, Object],
        default: [],
    },
    values: {
        type: [Array, Object],
        default: [],
    },
    multiple: {
        type: Boolean,
        default: false,
    },
    options: {
        type: [Array, Object],
        default: [],
    },
    errorsName: {
        type: String,
        default: "",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    required: {
        type: Boolean,
        default: false,
    },
});

async function change(value) {
    props.errors[props.errorsName ?? props.name] = [];
    emit("change", value);
}

async function onRemoveTag(tag) {
    emit("onRemoveTag", tag);
}

async function onAddTag(tag) {
    emit("onAddTag", tag);
}

async function clear() {
    emit("clear", "");
}

async function blur() {
    setTimeout(() => {
        emit("blur", "");
    }, 800);
}
</script>
<style scoped>
:deep() {
    --vs-dropdown-option--active-bg: #07a55c;
    --vs-dropdown-option--active-color: #eeeeee;
    --form-select-color: #eeeeee;
}
</style>
