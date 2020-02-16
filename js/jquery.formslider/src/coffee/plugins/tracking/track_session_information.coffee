class @TrackSessionInformation extends AbstractFormsliderPlugin
  @config:
    onReady: null
    onReadyInternal: (plugin) ->
      plugin.inform('url',       location.href, false)
      plugin.inform('useragent', navigator.userAgent, false)
      plugin.inform('referer',   document.referrer, false)
      dimension = $(window).width() + 'x' + $(window).height()
      plugin.inform('dimension', dimension, false)
      plugin.inform('jquery.formslider.version',
        plugin.formslider.config.version, false)

    buildHiddenInput: (name, value) ->
      $('<input>', {
        type: 'hidden'
        name: "info[#{name}]"
        class: 'info'
        value: value
      })

  init: =>
    @on('first-interaction', @onFirstInteraction)

  onFirstInteraction: =>
    @config.onReadyInternal(@) if @config.onReadyInternal
    @config.onReady(@) if @config.onReady

  inform: (name, value, trackEvent = true) =>
    @track(name, value, 'info') if trackEvent

    @container.append(
      @config.buildHiddenInput(name, value)
    )
