<validation-provider v-slot="{ errors }" name="Nama Bank" :rules="bankRules">
	<v-autocomplete
		:items="items"
		item-text="name"
		clearable
		:class="bankClass"
		v-model="bank"
		:name="bankInputName"
		:label="bankLabel"
		:error-messages="errors"
		:disabled="disabled">
	</v-autocomplete>
</validation-provider>