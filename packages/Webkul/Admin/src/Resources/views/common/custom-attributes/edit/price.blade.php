<input
    type="text"
    ref="inputRef"
    name="{{ $attribute->code }}"
    class="control"
    id="{{ $attribute->code }}"
    value="{{ old($attribute->code) ?: $value}}"
    v-validate="'{{$validations}}'"
    data-vv-as="&quot;{{ $attribute->name }}&quot;"
/>

<script>
    import { useCurrencyInput } from 'vue-currency-input'
    
    export default {
      name: 'CurrencyInput',
      props: {
        modelValue: Number, // Vue 2: value
        options: Object
      },
      setup(props) {
        const { inputRef } = useCurrencyInput(props.options)
    
        return { inputRef }
      }
    }
    </script>