(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2],{

/***/ "./Modules/SalesAgent/Resources/js/components/Agency/Form.vue":
/*!********************************************************************!*\
  !*** ./Modules/SalesAgent/Resources/js/components/Agency/Form.vue ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Form.vue?vue&type=script&lang=js& */ "./Modules/SalesAgent/Resources/js/components/Agency/Form.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
var render, staticRenderFns




/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  _Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"],
  render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "Modules/SalesAgent/Resources/js/components/Agency/Form.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./Modules/SalesAgent/Resources/js/components/Agency/Form.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./Modules/SalesAgent/Resources/js/components/Agency/Form.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./Form.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./Modules/SalesAgent/Resources/js/components/Agency/Form.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./Modules/SalesAgent/Resources/js/components/Agency/Form.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./Modules/SalesAgent/Resources/js/components/Agency/Form.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vee_validate__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vee-validate */ "./node_modules/vee-validate/dist/vee-validate.esm.js");
/* harmony import */ var vee_validate_dist_rules__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vee-validate/dist/rules */ "./node_modules/vee-validate/dist/rules.js");
/* harmony import */ var vee_validate_dist_locale_id_json__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vee-validate/dist/locale/id.json */ "./node_modules/vee-validate/dist/locale/id.json");
var vee_validate_dist_locale_id_json__WEBPACK_IMPORTED_MODULE_2___namespace = /*#__PURE__*/__webpack_require__.t(/*! vee-validate/dist/locale/id.json */ "./node_modules/vee-validate/dist/locale/id.json", 1);



Object(vee_validate__WEBPACK_IMPORTED_MODULE_0__["extend"])('required', vee_validate_dist_rules__WEBPACK_IMPORTED_MODULE_1__["required"]);
Object(vee_validate__WEBPACK_IMPORTED_MODULE_0__["extend"])('email', vee_validate_dist_rules__WEBPACK_IMPORTED_MODULE_1__["email"]);
Object(vee_validate__WEBPACK_IMPORTED_MODULE_0__["extend"])('max', vee_validate_dist_rules__WEBPACK_IMPORTED_MODULE_1__["max"]);
Object(vee_validate__WEBPACK_IMPORTED_MODULE_0__["extend"])('numeric', vee_validate_dist_rules__WEBPACK_IMPORTED_MODULE_1__["numeric"]);
Object(vee_validate__WEBPACK_IMPORTED_MODULE_0__["localize"])('id', vee_validate_dist_locale_id_json__WEBPACK_IMPORTED_MODULE_2__);
/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    ValidationObserver: vee_validate__WEBPACK_IMPORTED_MODULE_0__["ValidationObserver"],
    ValidationProvider: vee_validate__WEBPACK_IMPORTED_MODULE_0__["ValidationProvider"]
  },
  props: {
    uri: {
      type: String,
      required: true
    },
    slug: {
      type: String,
      "default": ''
    }
  },
  data: function data() {
    return {
      field_state: false,
      formAlert: false,
      formAlertText: '',
      formAlertState: 'info',
      form_data: {
        agency_name: '',
        agency_email: '',
        agency_phone: '',
        agency_address: '',
        province: '',
        city: ''
      }
    };
  },
  methods: {
    submit: function submit() {
      var _this = this;

      this.$refs.observer.validate().then(function (success) {
        if (!success) {
          return;
        }

        _this.postFormData();
      });
    },
    clear: function clear() {
      this.form_data = {
        agency_name: '',
        agency_email: '',
        agency_phone: '',
        agency_address: '',
        province: '',
        city: ''
      };
      this.$refs.observer.reset();
    },
    postFormData: function postFormData() {
      var _this2 = this;

      var data = new FormData();
      data.append("agency_name", this.form_data.agency_name);
      data.append("agency_email", this.form_data.agency_email);
      data.append("agency_phone", this.form_data.agency_phone);
      data.append("agency_address", this.form_data.agency_address);
      data.append("province", this.form_data.province);
      data.append("city", this.form_data.city);

      if (this.slug) {
        data.append("_method", "put");
      }

      this.field_state = true;
      axios.post(this.uri, data).then(function (response) {
        if (response.data.success) {
          Toast.fire({
            icon: 'success',
            title: response.data.message,
            onClose: function onClose() {
              _this2["goto"](_this2.base_url() + _this2.ziggy('master.biaya-kuliah.index').url());
            }
          });
        } else {
          Toast.fire({
            icon: 'warning',
            title: response.data.message,
            onClose: function onClose() {
              _this2.setState(false);
            }
          });
        }
      })["catch"](function (error) {
        Toast.fire({
          icon: 'error',
          title: error.response.data.message,
          onClose: function onClose() {
            _this2.setState(false);
          }
        });
      });
    }
  }
});

/***/ })

}]);