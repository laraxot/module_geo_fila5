  _switchLayer() {
      // Add guard checks to prevent null reference errors
      if (!this._layers || !this._layers[this._currentLayer]) {
          return;
      }

      const layers = ['street', 'satellite', 'topo'];
      const currentIndex = layers.indexOf(this._currentLayer);
      const nextIndex = (currentIndex + 1) % layers.length;
      const nextLayer = layers[nextIndex];

      // Check if nextLayer exists and has a map instance
      if (!this._layers[nextLayer] || !this._layers[nextLayer]._map) {
          return;
      }

      // Remove current layer only if it exists
      if (this._layers[this._currentLayer] && this._layers[this._currentLayer]._map) {
          this._map.removeLayer(this._layers[this._currentLayer]);
      }

      // Add next layer
      this._layers[nextLayer].addTo(this._map);

      this._currentLayer = nextLayer;
  }