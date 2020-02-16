class @LazyLoad extends AbstractFormsliderPlugin
  @config =
    lazyClass: 'lazy-load'
    dataKey: 'src'
    waitBeforeLoad: 10

  init: =>
    @doLazyLoad(@slideByIndex(0))
    @on('before', @onBefore)

  onBefore: (event, current, direction, next)=>
    @doLazyLoad(next)

  doLazyLoad: (slide) =>
    images = $("img.#{@config.lazyClass}", slide)
    return unless images.length

    @images2load = images.length
    @slide2process = slide
    setTimeout(
      =>
        $("img.#{@config.lazyClass}", slide).each( @_loadLazyCallback )
      ,
      @config.waitBeforeLoad
    )

  _loadLazyCallback: (index, el) =>
    $el = $(el)
    $el.on('load', @_loadedCallback)
      .attr('src', $el.data(@config.dataKey))
      .removeData(@config.dataKey)
      .removeClass(@config.lazyClass)

  _loadedCallback: =>
    --@images2load
    @trigger('do-equal-height', @slide2process) if @images2load == 0
