var MiniMasonry = function (t) { return this._sizes = [], this._columns = [], this._container = null, this._count = null, this._width = 0, this._gutter = 0, this._resizeTimeout = null, this.conf = { baseWidth: 255, gutter: 10, container: null, minify: !0 }, this.init(t), this }; MiniMasonry.prototype.init = function (t) { t.container; for (var i in this.conf) void 0 != t[i] && (this.conf[i] = t[i]); if (this._container = document.querySelector(this.conf.container), !this._container) throw new Error("Container not found"); window.addEventListener("resize", this.resizeThrottler.bind(this)), this.layout() }, MiniMasonry.prototype.reset = function () { this._sizes = [], this._columns = [], this._count = null, this._width = this._container.clientWidth; var t = 2 * this.conf.gutter + this.conf.baseWidth; this._width < t && (this._width = t, this._container.style.minWidth = t + "px"), this._gutter = this.conf.gutter, this._width < 530 && (this._gutter = 5) }, MiniMasonry.prototype.layout = function () { if (this._container) { this.reset(), this._count = Math.floor((this._width - this._gutter) / (this.conf.baseWidth + this.conf.gutter)); for (var t = (this._width - this._gutter) / this._count - this._gutter, i = 0; i < this._count; i++)this._columns[i] = 0; for (var n = this._container.querySelectorAll(this.conf.container + " > *"), s = 0; s < n.length; s++)this._sizes[s] = n[s].clientHeight; var e = this._gutter; this._count > this._sizes.length && (e = (this._width - this._sizes.length * t - this._gutter) / 2 - this._gutter); for (var h = 0; h < n.length; h++) { var o = this.conf.minify ? this.getShortest() : this.getNextColumn(h); n[h].style.width = Math.round(t) + "px"; var r = e + (t + this._gutter) * o, u = this._columns[o]; n[h].style.transform = "translate3d(" + Math.round(r) + "px," + Math.round(u) + "px,0)", this._columns[o] += this._sizes[h] + this.conf.gutter } this._container.style.height = this._columns[this.getLongest()] + "px" } }, MiniMasonry.prototype.getNextColumn = function (t) { return t % this._columns.length }, MiniMasonry.prototype.getShortest = function () { for (var t = 0, i = 0; i < this._count; i++)this._columns[i] < this._columns[t] && (t = i); return t }, MiniMasonry.prototype.getLongest = function () { for (var t = 0, i = 0; i < this._count; i++)this._columns[i] > this._columns[t] && (t = i); return t }, MiniMasonry.prototype.resizeThrottler = function () { this._resizeTimeout || (this._resizeTimeout = setTimeout(function () { this._resizeTimeout = null, this._container.clientWidth != this._width && this.layout() }.bind(this), 66)) };