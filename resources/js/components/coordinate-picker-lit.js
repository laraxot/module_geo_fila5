if (typeof customElements !== 'undefined' && !customElements.get('coordinate-picker-lit')) {
    customElements.define('coordinate-picker-lit', CoordinatePickerField);
}
