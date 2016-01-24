<script src="/builds/js/components.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('header .button-collapse').sideNav();
        // only for photo
        $(window)
            .scrollTop(0)
            .scroll(function(e) {
                vm.scroll(e.originalEvent);
            }
        );
        // only for photo end
    });
    var window_height = $(window).height();
    var PhotoList = Vue.extend({
        props: [
            'collection',
            'photos'
        ],
        created: function () {
            var self = this;
            this.photos = this.collection.splice(0, 3);
            this.$on('scroll-bottom', function() {
                if (this.collection.length > 0) {
                    this.photos = this.photos.concat(this.collection.splice(0, 3));
                }
            });
        },
        methods: {
            loaded: function(e) {
                $(e.target).materialbox();
            }
        }
    });

    var vm = new Vue({
        el: '#photo-list',
        data: {

        },
        methods: {
            scroll: function (e) {
                var scroll_top = $(window).scrollTop();
                if ((scroll_top + window_height + 100) >= document.body.offsetHeight) {
                    this.$broadcast('scroll-bottom');
                }
            }
        },
        components: {
            photo_list: PhotoList
        }
    });
</script>
