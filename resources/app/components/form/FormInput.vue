<template>
    <div class="mb-3">
        <el-form-item
            v-if="showLabel"
            :label="$t(props.label)"
            class="mb-0"
            prop="name"
            :required="required"
        >
        </el-form-item>
        <div class="position-relative">
            <el-input
                v-model="props.model[name]"
                @input="props.errors[name] = []"
                :autosize="props.autosize"
                :class="
                    props.errors[name]
                        ? `is-invalid ${props.class}`
                        : props.class
                "
                :placeholder="
                    placeholder !== ''
                        ? placeholder
                        : $t('placeholder') + $t(props.label)
                "
                :readonly="props.disabled"
                :type="
                    props.type == 'password'
                        ? showPass
                            ? 'text'
                            : 'password'
                        : props.type
                "
                :step="step"
                :min="min"
                :max="max"
                @change="change"
            />
            <i
                v-if="type == 'password'"
                class="toggle-password fa-solid"
                :class="showPass ? 'fa-eye-slash' : 'fa-eye'"
                @click.prevent="showPass = !showPass"
            ></i>
        </div>
        <form-validation-errors
            :errors="props.errors"
            :name="errorsName !== '' ? errorsName : props.name"
        />
    </div>
</template>
<script setup>
import { ref } from "vue";
const props = defineProps({
    class: {
        type: String,
        default: "",
    },
    label: {
        type: String,
        default: "",
    },
    type: {
        type: String,
        default: "",
    },
    model: {
        type: [Array, Object],
    },
    name: {
        type: [Number, String],
        default: "",
    },
    errors: {
        type: [Array, Object],
        default: [],
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    autosize: {
        type: [Array, Object],
        default: {},
    },
    placeholder: {
        type: String,
        default: "",
    },
    errorsName: {
        type: String,
        default: "",
    },
    showLabel: {
        type: Boolean,
        default: true,
    },
    min: {
        type: String,
        default: "",
    },
    max: {
        type: String,
        default: "",
    },
    // for input number
    step: {
        type: String,
        default: "",
    },
    required: {
        type: Boolean,
        default: false,
    },
});
async function change() {
    props.errors[props.errorsName ?? props.name] = [];
}
const showPass = ref(false);
</script>
