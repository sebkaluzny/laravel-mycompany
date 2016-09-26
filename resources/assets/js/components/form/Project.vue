<template>
    <form v-on:submit.prevent="submitCallback" enctype="multipart/form-data">
        <div class="ui equal width form" v-bind:class="{ 'loading': busy }">
            <div class="fields">
                <div class="field">
                    <label>Nazwa</label>
                    <input type="text" placeholder="Nazwa" v-model="form.name">
                </div>
            </div>
        </div>
        <button type="submit" style="display: none;"></button>
    </form>
</template>
<script type="text/ecmascript-6">
    export default{
        props: {
            submitCallback: {
                type: Function
            },

            form: {
                default: () => { return {} }
            },

            busy: {
                default: false,
            }
        },
    }
</script>