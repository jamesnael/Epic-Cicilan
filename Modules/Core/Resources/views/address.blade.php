<div class="address-form">
	<validation-provider v-slot="{ errors }" name="Nama Provinsi" :rules="provinceRules">
		<v-autocomplete
			:items="items"
			item-text="name"
			clearable
			:class="provinceClass"
			v-model="province"
			:name="provinceInputName"
			:label="provinceLabel"
			:error-messages="errors"
			@change="refreshCity"
			:disabled="disabled">
		</v-autocomplete>
	</validation-provider>
	<validation-provider v-slot="{ errors }" name="Nama Kota" :rules="cityRules">
		<v-autocomplete
			:items="cityOptions"
			item-text="city"
			clearable
			:class="cityClass"
			v-model="city"
			:name="cityInputName"
			:label="cityLabel"
			:error-messages="errors"
			:disabled="disabled">
		</v-autocomplete>
	</validation-provider>
</div>