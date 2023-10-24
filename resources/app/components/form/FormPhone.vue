<template>
    <div class="mb-3">
        <el-form-item :label="$t(props.label)" class="mb-0" :required="required"> </el-form-item>
        <div class="row">
            <div class="col-md-3" v-if="props.allowCode">
                <div class="mb-3">
                    <el-select v-model="props.model[props.countryCodeName]"
                               :clearable="true"
                               :filterable="true"
                               :class="props.errors[name] ? `is-invalid ${props.class}` : props.class"
                               remote
                               :remote-method="filterCountry"
                               collapse-tags
                               collapse-tags-tooltip>
                        <el-option
                            v-for="item in countryOptions"
                            :key="item.id"
                            :label="codeKey.map(x=>item[x]).join(' ')  /*item['flag']+'  '+item[codeKey]*/"
                            :value="item[codeValue]">
                            <span style="float: left" >
                                {{ item[codeLabel] + ' ' + item[codeValue] }}
                            </span>
                        </el-option>
                    </el-select>
                    <form-validation-errors :errors="props.errors"
                                            :name="errorsCodeName !== '' ? errorsCodeName : props.countryCodeName"/>
                </div>
            </div>

           <div :class="props.allowCode? 'col-md-9' : 'col-md-12'">
               <el-input
                   :class="props.errors[name] ? `is-invalid ${props.class}` : props.class"
                   v-model="props.model[name]"
                   type="text"
                   :placeholder="$t(props.label)"
                   :minlength="props.minlength"
                   :maxlength="props.maxlength"
               />
               <form-validation-errors :errors="props.errors" :name="errorsName !== '' ? errorsName : props.name"/>
           </div>


        </div>

    </div>
</template>
<script setup>
import FormSelect from "@components/form/FormSelect.vue";
import {onMounted, ref} from "vue";

const props = defineProps({
    class: {
        type: String,
        default: "",
    },
    label: {
        type: String,
        default: "",
    },
    minlength: {
        type: String,
        default: "8",
    },
    maxlength: {
        type: String,
        default: "11",
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
    errorsName: {
        type: String,
        default: "",
    },
    allowCode: {
        type: Boolean,
        default: false,
    },
    countryCodeName: {
        type: String,
        default: "",
    },
    codeKey:{
        type:[Array, Object],
        default:''
    },
    codeValue:{
        type:String,
        default:''
    },
    codeLabel:{
        type:String,
        default:''
    },
    errorsCodeName:{
        type: String,
        default: "",
    },
    required:{
        type:Boolean,
        default:false
    }
});
const countryList = ref([
        {   id:1,
            name: "Bahrain",
            flag: "🇧🇭",
            code: "+973"
        },
        {
            id:1,
            name: "Brazil",
            flag: "🇧🇷",
            code: "+55"
        },
        {
            id:1,
            name: "Egypt",
            flag: "🇪🇬",
            code: "+20"
        },
        {
            id:1,
            name: "France",
            flag: "🇫🇷",
            code: "+33"
        },
        {
            id:1,
            name: "Germany",
            flag: "🇩🇪",
            code: "+49"
        },
        {
            id:1,
            name: "Ghana",
            flag: "🇬🇭",
            code: "+233"
        },
        {
            id:1,
            name: "Gibraltar",
            flag: "🇬🇮",
            code: "+350"
        },
        {
            id:1,
            name: "Greece",
            flag: "🇬🇷",
            code: "+30"
        },
        {
            id:1,
            name: "Iraq",
            flag: "🇮🇶",
            code: "+964"
        },
        {
            id:1,
            name: "Ireland",
            flag: "🇮🇪",
            code: "+353"
        },
        {
            id:1,
            name: "Italy",
            flag: "🇮🇹",
            code: "+39"
        },
        {
            id:1,
            name: "Jordan",
            flag: "🇯🇴",
            code: "+962"
        },
        {
            id:1,
            name: "Kuwait",
            flag: "🇰🇼",
            code: "+965"
        },
        {
            id:1,
            name: "Lebanon",
            flag: "🇱🇧",
            code: "+961"
        },
        {
            id:1,
            name: "Lesotho",
            flag: "🇱🇸",
            code: "+266"
        },
        {
            id:1,
            name: "Liberia",
            flag: "🇱🇷",
            code: "+231"
        },
        {
            id:1,
            name: "Libyan Arab Jamahiriya",
            flag: "🇱🇾",
            code: "+218"
        },
        {
            id:1,
            name: "Oman",
            flag: "🇴🇲",
            code: "+968"
        },
        {
            id:1,
            name: "Qatar",
            flag: "🇶🇦",
            code: "+974"
        },

        {
            id:1,
            name: "Saudi Arabia",
            flag: "🇸🇦",
            code: "+966"
        },
        {
            id:1,
            name: "United Kingdom",
            flag: "🇬🇧",
            code: "+44"
        },

]);

const countryOptions = ref(countryList.value);
const filterCountry = (key)=>{
    if(key){
        countryOptions.value =  countryList.value.filter((item)=>{
            return item.name.toLowerCase().includes(key) ||
                item.name.toUpperCase().includes(key) ||
                item.code.includes(key);
        })
    }else{
        countryOptions.value = countryList.value
    }

}
onMounted(()=>{

})
</script>

