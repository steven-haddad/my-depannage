class @ContentReplace extends AbstractFormsliderPlugin
  @config =
    locale: "en-us"
    selector: '.question-headline, .headline, .answer-headline, textarea'
    mappings:
      '{{month}}': (plugin, content) ->
        (new Date()).getMonth()

      '{{month-name}}': (plugin, content) ->
        (new Date()).toLocaleString(plugin.config.locale, { month: "long" })

      '{{year}}': (plugin, content) ->
        (new Date()).getFullYear()

      '{{day}}': (plugin, content) ->
        (new Date()).getDate()

      '{{day-name}}': (plugin, content) ->
        (new Date()).toLocaleString(plugin.config.locale, { day: "long" })

      '{{date}}': (plugin, content) ->
        (new Date()).toLocaleString(plugin.config.locale)

      '{{time}}': (plugin, content) ->
        (new Date()).getTime()

  init: =>
    @slides.each(@_doWithSlide)

  makeRegexp: (mapping) ->
    regexp = mapping.replace(/[-[\]{}()*+!<=:?.\/\\^$|#\s,]/g, '\\$&')
    new RegExp("#{regexp}", 'g')

  _doWithSlide: (index, slide) =>
    $elements = $(@config.selector, slide)
    $elements.each(@_doWithElement)

  _doWithElement: (index, element) =>
    $element = $(element)
    html     = $element.html()
    replaced = false
    for mapping, callback of @config.mappings
      if html.indexOf(mapping) > -1
        html = html.replace(@makeRegexp(mapping), callback(@, html))
        replaced = true

    $element.html(html) if replaced
