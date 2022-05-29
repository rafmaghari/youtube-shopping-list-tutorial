require('./bootstrap');

import { createApp } from 'vue'
import ExampleComponent from './components/ExampleComponent'
import ShoppingList from './components/ShoppingList'

const app = createApp({})

app.component('example-component', ExampleComponent)
app.component('shopping-list', ShoppingList)

app.mount('#app')
