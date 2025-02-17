<template>
<div>
    {{title}}&nbsp;
    <span @click="updateList"><i class="fa fa-refresh" aria-hidden="true"></i></span>&nbsp;
    <span @click="showAddForm"><i class="fa fa-plus-square-o" aria-hidden="true"></i></span>&nbsp;
    <span @click="copyShareLink"><i class="fa fa-share-alt" aria-hidden="true"></i></span>
</div>
<form class="hidden" :id="`checklist_add_form_${widgetId}`" @submit="addItem">
    <input type="text" :id="`checklist_add_input_${widgetId}`">
    <button>Add</button>
</form>
<ul class="list-none">
    <template v-for="item, index in list">
        <span class="float-right" @click="deleteItem" :data-index="`${index}`"><i class="fa fa-times" aria-hidden="true"></i></span>
        <li @click="toggleChecked">
            <input
                type="checkbox"
                :id="`checklist_${widgetId}_${index}`"
                :data-index="`${index}`"
                :checked="item.checked"
            > <label :class="{'line-through': list[index].checked}" :for="`checklist_${widgetId}_${index}`">{{ item.text }}</label>
        </li>
    </template>
</ul>
</template>

<script>
export default {
    data() {     
        return {
            list: [],
        }
    },
    methods: {
        addItem(evt) {
            evt.preventDefault();

            evt.target.classList.add('hidden');

            let text = evt.target.querySelector('input').value;
            evt.target.querySelector('input').value = '';

            this.list.push({
                text: text,
                checked: false,
            });

            this.putData();
        },
        copyShareLink() {
            navigator.clipboard.writeText(window.location.href + 'checklist/' + this.widgetId);
        },
        deleteItem(evt) {
            console.log(evt, evt.target.dataset.index);
            let index = evt.target.dataset.index == undefined ? evt.target.parentNode.dataset.index : evt.target.dataset.index;
            this.list.splice(index, 1);
            this.putData();
        },
        putData() {
            fetch('/api/v0/widget/data/' + this.widgetId, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(this.list),
            });
        },
        showAddForm() {
            let form = document.querySelector(`#checklist_add_form_${this.widgetId}`);
            form.classList.remove('hidden');
            form.querySelector('input').focus();
        },
        toggleChecked(evt) {
            evt.preventDefault();
            let input;
            if (evt.target.tagName == 'LI') {
                input = evt.target.querySelector('input');
            } else if(evt.target.tagName == 'INPUT') {
                input = evt.target;
            } else if(evt.target.tagName == 'LABEL') {
                input = evt.target.parentNode.querySelector('input');
            }
            this.list[input.dataset.index].checked = !this.list[input.dataset.index].checked;
            this.putData();
        },
        updateList() {
            fetch('/api/v0/widget/data/' + this.widgetId)
                .then(response => response.json())
                .then(data => {
                    this.list = data;
                })
        },
    },
    mounted: function() {
        this.updateList()
    },
    props: {
        'title': String,
        'widgetId': String,
    }
  }
</script>
