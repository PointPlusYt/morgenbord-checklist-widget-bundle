
<script setup>
import { ref, nextTick, onMounted } from 'vue';

const props = defineProps({
    title: String,
    widgetId: String
});

const list = ref([]);
let addFormshow = ref(false);
const addFormInput = ref(null);
const addFormToggle = () => {
    addFormshow.value = !addFormshow.value;
    if (addFormshow.value) {
        nextTick(() => addFormInput.value?.focus());
    }
};

const addItem = (evt) => {
    addFormshow.value = false;
    let text = addFormInput.value.value;
    addFormInput.value.value = '';
    
    list.value.push({
        text: text,
        checked: false,
    });
    
    putData();
};

const copyShareLink = () => {
    navigator.clipboard.writeText(window.location.href + 'checklist/' + props.widgetId);
};

const deleteItem = (evt) => {
    console.log(evt, evt.target.dataset.index);
    let index = evt.target.dataset.index == undefined ? evt.target.parentNode.dataset.index : evt.target.dataset.index;
    list.value.splice(index, 1);
    putData();
};

const putData = () => {
    fetch('/api/v0/widget/data/' + props.widgetId, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(list.value),
    });
};

const toggleChecked = (evt) => {
    evt.preventDefault();
    let input;
    if (evt.target.tagName == 'LI') {
        input = evt.target.querySelector('input');
    } else if(evt.target.tagName == 'INPUT') {
        input = evt.target;
    } else if(evt.target.tagName == 'LABEL') {
        input = evt.target.parentNode.querySelector('input');
    }
    list.value[input.dataset.index].checked = !list.value[input.dataset.index].checked;
    putData();
};

const updateList = () => {
    fetch('/api/v0/widget/data/' + props.widgetId)
        .then(response => response.json())
        .then(data => {
            list.value = data;
        })
};

onMounted(() => {
    updateList();
});
</script>

<template>
<div class="flex justify-around items-center">
    <ul class="menu menu-xs menu-horizontal bg-base-200 rounded-box">
        <li @click="updateList">
            <a>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </a>
        </li>
        <li @click="addFormToggle">
            <a>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
        </li>
        <li @click="copyShareLink">
            <a>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                </svg>
            </a>
        </li>
    </ul>
</div>
<form v-show="addFormshow" :id="`checklist_add_form_${props.widgetId}`" @submit.prevent="addItem">
    <div class="join">
            <label class="input join-item">
            <input ref="addFormInput" type="text" :id="`checklist_add_input_${props.widgetId}`" placeholder="Something to do" required />
            </label>
        <button type="submit" class="btn btn-neutral join-item">Add</button>
    </div>
</form>
<ul class="list-none">
    <template v-for="item, index in list">
        <li @click="toggleChecked" class="flex justify-between items-center">
            <label :class="{'line-through': list[index].checked}" :for="`checklist_${widgetId}_${index}`">
            <input
            type="checkbox"
            class="checkbox checkbox-xl"
            :id="`checklist_${props.widgetId}_${index}`"
            :data-index="`${index}`"
            :checked="item.checked"
            > {{ item.text }}</label>
            <span class="btn btn-xs btn-danger" @click="deleteItem" :data-index="`${index}`">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-3 w-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </span>
        </li>
    </template>
</ul>
</template>
