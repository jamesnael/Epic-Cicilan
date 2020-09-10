<validation-provider v-slot="{ errors }" name="Pekerjaan" :rules="paymentMethodRules">
	<v-autocomplete
		:items="items"
		item-text="name"
		clearable
		:class="paymentMethodClass"
		v-model="paymentMethod"
		:name="paymentMethodInputName"
		:label="paymentMethodLabel"
		:error-messages="errors"
		:disabled="disabled">
	</v-autocomplete>
</validation-provider>