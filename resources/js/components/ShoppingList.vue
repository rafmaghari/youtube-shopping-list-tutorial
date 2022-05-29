<template>
    <div class="flex flex-col justify-center items-center ">
        <div class="p-5  rounded-lg">
            <!--  this will trigger the submit           -->
            <form class="mb-6" @submit.prevent="submitHandler">
                <div class="flex space-x-1 mb-2">
                    <div class="flex flex-col w-1/4">
                        <label class="mb-2 uppercase font-bold  text-grey-darkest" >QTY</label>
                        <input class="border py-2 px-3 text-grey-darkest" type="number" name="first_name" v-model="state.form.qty">
                    </div>
                    <div class="flex flex-col w-3/4">
                        <label class="mb-2 uppercase font-bold  text-grey-darkest">NAME</label>
                        <input class="border py-2 px-3 text-grey-darkest" type="text" name="last_name" v-model="state.form.name">
                    </div>
                </div>
                <div class="flex flex-col space-y-1">
                    <!--  let's change the text from add to update list -->
                    <!--      change text to update if is editing              -->
                    <button class="bg-blue-500 hover:bg-blue-200 text-white uppercase py-2 rounded" type="submit">{{state.isEditing ? 'UPDATE' : 'ADD TO LIST' }}</button>
                    <!--       show only when editing is true   change type button       -->
                    <button class="bg-gray-500 hover:bg-gray-200 text-white uppercase py-2 rounded" type="button" v-if="state.isEditing" @click="cancelEditing">CANCEL</button>
                </div>
            </form>
            <p class="mb-2 uppercase font-bold text-grey-darkest">Shopping List</p>
            <div class="bg-white shadow w-full">
                <ul class="divide-y divide-gray-100">
                    <!--  let's put data in a loop -->
                    <li class="p-3 hover:bg-blue-500 hover:text-blue-200 flex justify-between" v-for="(list,index) in state.shopping_list" :key="list.id">
                        {{list.qty}} - {{list.name}}
                        <div class="flex space-x-1">
                            <p class="cursor-pointer" @click="editData(list)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </p>
                            <p class="cursor-pointer" @click="deleteData(index, list.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<!--sorry for the mistake instead of script it should be setup-->
<script setup>
    import {reactive, onMounted} from 'vue';
    //lets call it on mount :)
    const state = reactive({
        form: {
            id: null,
            qty: null,
            name: null
        },
        shopping_list: [],
        isEditing: false
    })
    onMounted(() => {
      // i forgot no need to use this in setup or composition api
      fetchData();
    });
    const submitHandler = () => {
        // let's use axios to request in backend
        //lets add condition if is editing it will call the update data function
        if (state.isEditing) {
           updateData()
        } else {
            axios.post('/shopping-list', state.form)
                .then(response => {
                    alert('Successfully added')
                    fetchData();
                })
                .catch(error => console.log(error))
        }
    }
    //  Let's add the fetching of data here

    const fetchData = () => {
        axios.get('/shopping-list-data')
        .then(response => {
            state.shopping_list = response.data.data
        })
        .catch(error => console.log(error))
    }

    //lets add delete and edit functionality
    const editData = (shoppingList) => {
       // this will populate the field in adding of data
        state.form.id = shoppingList.id
        state.form.qty = shoppingList.qty
        state.form.name = shoppingList.name
        state.isEditing = true
    }

    const updateData = () => {
        axios.put('/shopping-list/' + state.form.id, state.form)
        .then(response => {
            fetchData();
            cancelEditing();
        })
        .catch(error => console.log(error))
    }
    const deleteData = (index,id) => {
        //lets delete a data
        //lets add confirmation
        if (window.confirm('Are you sure, you want to delete this data?')) {
            axios.delete('/shopping-list/' + id)
                .then(response => {
                    state.shopping_list.splice(index,1);
                    alert('deleted')
                })
                .catch(error => console.log(error))
        }

    }

    const cancelEditing = () => {
        state.isEditing = false;
        state.form.id = null;
        state.form.qty = null;
        state.form.name = null;
    }
</script>

<style scoped>

</style>
