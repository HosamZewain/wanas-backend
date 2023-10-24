<script setup>
import { onMounted } from 'vue'

const props = defineProps({
    modelValue: {
        type: [Object],
        required: true,
    },
    permissions: {
        type: Array,
        default: []
    },
    groupTitle: {
        type: String,
        default: null
    },
    selectedPermissions: {
        type: Array,
        default: []
    },
    readonly: {
        type: Boolean,
        default: false
    }

})
const allSelected = () => {
    if (props.modelValue[props.groupTitle]?.length === props.permissions.length) {
        return true
    }
    return false;
}

const selectAll = (e) => {
    if (e.target.checked) {
        return props.permissions.forEach(perm => props.modelValue[props.groupTitle].push(perm.id))
    }
    props.modelValue[props.groupTitle] = [];
}

onMounted(async () => {
    if (!props.modelValue[props.groupTitle]) props.modelValue[props.groupTitle] = [];

})
</script>

<template>
    <div class="card custom-card">
        <div class="card-header custom-card-header pt-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" :id="`${groupTitle}-checkbox`" :checked="allSelected()"
                    @click="selectAll($event)" :disabled="readonly">
                <label class="form-check-label" for="flexCheckChecked" :for="`${groupTitle}-checkbox`">
                    {{ $t(`${groupTitle}`) }}
                </label>
            </div>
        </div>
        <div class="card-body">
            <div class="form-check mb-2" v-for="(permission, index) in permissions" :key="index">
                <input class="form-check-input" type="checkbox" v-model="modelValue[groupTitle]"
                    :id="`checkbox-${permission.id}`" :value="permission.id" :disabled="readonly">
                <label class="form-check-label" :for="`checkbox-${permission.id}`">
                    {{ $t(`${permission.name}`) }}
                </label>
            </div>
        </div>
    </div>
</template>
