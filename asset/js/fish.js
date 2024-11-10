var RENDERER = {
        POINT_INTERVAL: 5,
        FISH_COUNT: 3,
        MAX_INTERVAL_COUNT: 50,
        INIT_HEIGHT_RATE: .5,
        THRESHOLD: 50,
        init: function() {
            this.setParameters(), this.reconstructMethods(), this.setup(), this.bindEvent(), this.render()
        },
        setParameters: function() {
            this.$window = $(window), this.$container = $("#j-fish-skip"), this.$canvas = $("<canvas />"), this.context = this.$canvas.appendTo(this.$container).get(0).getContext("2d"), this.points = [], this.fishes = [], this.watchIds = []
        },
        createSurfacePoints: function() {
            var t = Math.round(this.width / this.POINT_INTERVAL);
            this.pointInterval = this.width / (t - 1), this.points.push(new SURFACE_POINT(this, 0));
            for (var i = 1; i < t; i++) {
                var e = new SURFACE_POINT(this, i * this.pointInterval),
                    h = this.points[i - 1];
                e.setPreviousPoint(h), h.setNextPoint(e), this.points.push(e)
            }
        },
        reconstructMethods: function() {
            this.watchWindowSize = this.watchWindowSize.bind(this), this.jdugeToStopResize = this.jdugeToStopResize.bind(this), this.startEpicenter = this.startEpicenter.bind(this), this.moveEpicenter = this.moveEpicenter.bind(this), this.reverseVertical = this.reverseVertical.bind(this), this.render = this.render.bind(this)
        },
        setup: function() {
            this.points.length = 0, this.fishes.length = 0, this.watchIds.length = 0, this.intervalCount = this.MAX_INTERVAL_COUNT, this.width = this.$container.width(), this.height = this.$container.height(), this.fishCount = this.FISH_COUNT * this.width / 500 * this.height / 500, this.$canvas.attr({
                width: this.width,
                height: this.height
            }), this.reverse = !1, this.fishes.push(new FISH(this)), this.createSurfacePoints()
        },
        watchWindowSize: function() {
            this.clearTimer(), this.tmpWidth = this.$window.width(), this.tmpHeight = this.$window.height(), this.watchIds.push(setTimeout(this.jdugeToStopResize, this.WATCH_INTERVAL))
        },
        clearTimer: function() {
            for (; this.watchIds.length > 0;) clearTimeout(this.watchIds.pop())
        },
        jdugeToStopResize: function() {
            var t = this.$window.width(),
                i = this.$window.height(),
                e = t == this.tmpWidth && i == this.tmpHeight;
            this.tmpWidth = t, this.tmpHeight = i, e && this.setup()
        },
        bindEvent: function() {
            this.$window.on("resize", this.watchWindowSize), this.$container.on("mouseenter", this.startEpicenter), this.$container.on("mousemove", this.moveEpicenter)
        },
        getAxis: function(t) {
            var i = this.$container.offset();
            return {
                x: t.clientX - i.left + this.$window.scrollLeft(),
                y: t.clientY - i.top + this.$window.scrollTop()
            }
        },
        startEpicenter: function(t) {
            this.axis = this.getAxis(t)
        },
        moveEpicenter: function(t) {
            var i = this.getAxis(t);
            this.axis || (this.axis = i), this.generateEpicenter(i.x, i.y, i.y - this.axis.y), this.axis = i
        },
        generateEpicenter: function(t, i, e) {
            if (!(i < this.height / 2 - this.THRESHOLD || i > this.height / 2 + this.THRESHOLD)) {
                var h = Math.round(t / this.pointInterval);
                h < 0 || h >= this.points.length || this.points[h].interfere(i, e)
            }
        },
        reverseVertical: function() {
            this.reverse = !this.reverse;
            for (var t = 0, i = this.fishes.length; t < i; t++) this.fishes[t].reverseVertical()
        },
        controlStatus: function() {
            for (var t = 0, i = this.points.length; t < i; t++) this.points[t].updateSelf();
            for (t = 0, i = this.points.length; t < i; t++) this.points[t].updateNeighbors();
            this.fishes.length < this.fishCount && 0 == --this.intervalCount && (this.intervalCount = this.MAX_INTERVAL_COUNT, this.fishes.push(new FISH(this)))
        },
        render: function() {
            requestAnimationFrame(this.render), this.controlStatus(), this.context.clearRect(0, 0, this.width, this.height), this.context.fillStyle = "rgba(250,128,114,0.7)";
            for (var t = 0, i = this.fishes.length; t < i; t++) this.fishes[t].render(this.context);
            this.context.save(), this.context.globalCompositeOperation = "xor", this.context.beginPath(), this.context.moveTo(0, this.reverse ? 0 : this.height);
            for (t = 0, i = this.points.length; t < i; t++) this.points[t].render(this.context);
            this.context.lineTo(this.width, this.reverse ? 0 : this.height), this.context.closePath(), this.context.fill(), this.context.restore()
        }
    },
    SURFACE_POINT = function(t, i) {
        this.renderer = t, this.x = i, this.init()
    };
SURFACE_POINT.prototype = {
    SPRING_CONSTANT: .03,
    SPRING_FRICTION: .9,
    WAVE_SPREAD: .3,
    ACCELARATION_RATE: .01,
    init: function() {
        this.initHeight = this.renderer.height * this.renderer.INIT_HEIGHT_RATE, this.height = this.initHeight, this.fy = 0, this.force = {
            previous: 0,
            next: 0
        }
    },
    setPreviousPoint: function(t) {
        this.previous = t
    },
    setNextPoint: function(t) {
        this.next = t
    },
    interfere: function(t, i) {
        this.fy = this.renderer.height * this.ACCELARATION_RATE * (this.renderer.height - this.height - t >= 0 ? -1 : 1) * Math.abs(i)
    },
    updateSelf: function() {
        this.fy += this.SPRING_CONSTANT * (this.initHeight - this.height), this.fy *= this.SPRING_FRICTION, this.height += this.fy
    },
    updateNeighbors: function() {
        this.previous && (this.force.previous = this.WAVE_SPREAD * (this.height - this.previous.height)), this.next && (this.force.next = this.WAVE_SPREAD * (this.height - this.next.height))
    },
    render: function(t) {
        this.previous && (this.previous.height += this.force.previous, this.previous.fy += this.force.previous), this.next && (this.next.height += this.force.next, this.next.fy += this.force.next), t.lineTo(this.x, this.renderer.height - this.height)
    }
};
var FISH = function(t) {
    this.renderer = t, this.init()
};
FISH.prototype = {
    GRAVITY: .4,
    init: function() {
        this.direction = Math.random() < .5, this.x = this.direction ? this.renderer.width + this.renderer.THRESHOLD : -this.renderer.THRESHOLD, this.previousY = this.y, this.vx = this.getRandomValue(4, 10) * (this.direction ? -1 : 1), this.renderer.reverse ? (this.y = this.getRandomValue(1 * this.renderer.height / 10, 4 * this.renderer.height / 10), this.vy = this.getRandomValue(2, 5), this.ay = this.getRandomValue(.05, .2)) : (this.y = this.getRandomValue(6 * this.renderer.height / 10, 9 * this.renderer.height / 10), this.vy = this.getRandomValue(-5, -2), this.ay = this.getRandomValue(-.2, -.05)), this.isOut = !1, this.theta = 0, this.phi = 0
    },
    getRandomValue: function(t, i) {
        return t + (i - t) * Math.random()
    },
    reverseVertical: function() {
        this.isOut = !this.isOut, this.ay *= -1
    },
    controlStatus: function(t) {
        this.previousY = this.y, this.x += this.vx, this.y += this.vy, this.vy += this.ay, this.renderer.reverse ? this.y > this.renderer.height * this.renderer.INIT_HEIGHT_RATE ? (this.vy -= this.GRAVITY, this.isOut = !0) : (this.isOut && (this.ay = this.getRandomValue(.05, .2)), this.isOut = !1) : this.y < this.renderer.height * this.renderer.INIT_HEIGHT_RATE ? (this.vy += this.GRAVITY, this.isOut = !0) : (this.isOut && (this.ay = this.getRandomValue(-.2, -.05)), this.isOut = !1), this.isOut || (this.theta += Math.PI / 20, this.theta %= 2 * Math.PI, this.phi += Math.PI / 30, this.phi %= 2 * Math.PI), this.renderer.generateEpicenter(this.x + (this.direction ? -1 : 1) * this.renderer.THRESHOLD, this.y, this.y - this.previousY), (this.vx > 0 && this.x > this.renderer.width + this.renderer.THRESHOLD || this.vx < 0 && this.x < -this.renderer.THRESHOLD) && this.init()
    },
    render: function(t) {
        t.save(), t.translate(this.x, this.y), t.rotate(Math.PI + Math.atan2(this.vy, this.vx)), t.scale(1, this.direction ? 1 : -1), t.beginPath(), t.moveTo(-30, 0), t.bezierCurveTo(-20, 15, 15, 10, 40, 0), t.bezierCurveTo(15, -10, -20, -15, -30, 0), t.fill(), t.save(), t.translate(40, 0), t.scale(.9 + .2 * Math.sin(this.theta), 1), t.beginPath(), t.moveTo(0, 0), t.quadraticCurveTo(5, 10, 20, 8), t.quadraticCurveTo(12, 5, 10, 0), t.quadraticCurveTo(12, -5, 20, -8), t.quadraticCurveTo(5, -10, 0, 0), t.fill(), t.restore(), t.save(), t.translate(-3, 0), t.rotate((Math.PI / 3 + Math.PI / 10 * Math.sin(this.phi)) * (this.renderer.reverse ? -1 : 1)), t.beginPath(), this.renderer.reverse ? (t.moveTo(5, 0), t.bezierCurveTo(10, 10, 10, 30, 0, 40), t.bezierCurveTo(-12, 25, -8, 10, 0, 0)) : (t.moveTo(-5, 0), t.bezierCurveTo(-10, -10, -10, -30, 0, -40), t.bezierCurveTo(12, -25, 8, -10, 0, 0)), t.closePath(), t.fill(), t.restore(), t.restore(), this.controlStatus(t)
    }
}, $(function() {
    RENDERER.init()
});