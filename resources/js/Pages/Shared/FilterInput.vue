<template>
    <div>
        <DropDown>
            <template #trigger>
                <button type="button" class="flex border px-3 py-1.5 text-xs md:text-sm rounded text-gray-500">
                    Filters 
                   <box-icon type='solid' name='chevron-down' size="xs" class="ml-1"></box-icon>
                 </button>
            </template>
            <template #content>
                <div class="w-max"> 
                    <select v-model="modelValue" @change="$emit('update:modelValue', $event.target.value)" name="trashed" id="trashed"
                        class=" w-full text-xs md:text-sm text-gray-500 px-2 py-1.5 border border-gray-300 rounded">
                        <option value=""></option>
                        <option value="with">With Trashed</option>
                        <option value="only">Only Trashed</option>
                    </select>
                </div>
            </template>
        </DropDown>
    </div>
</template>

<script setup>
import DropDown from './DropDown.vue';
import {ref} from 'vue';

const modelValue = ref('')

defineEmits(['update:modelValue'])
</script>
 