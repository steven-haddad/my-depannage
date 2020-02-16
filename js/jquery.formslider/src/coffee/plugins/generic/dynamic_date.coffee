class @DynamicDate extends AbstractFormsliderPlugin
  @cache  = {}
  @config =
    locale: "en-us"

    selector: '.question-headline, .headline, .answer-headline, textarea'

    formats:
      day:       { day: 'numeric', weekday: 'long'}
      date:      { day: '2-digit', month: "long" }
      monthName: { month: "long", year: 'numeric' }
      dayName:   { day: "long" }

    mappings:
      '\{\{date([-+0-9]*)\}\}': (p, match, content) ->
        d = (new Date())
        unless content[0] in ['-', '+']
          return d.toLocaleString(p.config.locale, p.config.formats.date)

        relativeDays = parseInt(content)
        d.setDate(d.getDate() + relativeDays)
        d.toLocaleString(p.config.locale, p.config.formats.date)

      '\{\{month-name([-+0-9]*)\}\}': (p, match, content) ->
        d = (new Date())
        unless content[0] in ['-', '+']
          return d.toLocaleString(p.config.locale, p.config.formats.monthName)

        relativeMonth = parseInt(content)
        d.setMonth(d.getMonth() + relativeMonth)
        d.toLocaleString(p.config.locale, p.config.formats.monthName)

      '\{\{month([-+0-9]*)\}\}': (p, match, content) ->
        d = (new Date())
        return d.getMonth() unless content[0] in ['-', '+']

        relativeMonth = parseInt(content)
        d.setMonth(d.getMonth() + relativeMonth)
        d.getMonth()

      '\{\{year([-+0-9]*)\}\}': (p, match, content) ->
        d = (new Date())
        return d.getFullYear() unless content[0] in ['-', '+']
        d.getFullYear() + parseInt(content)

      '\{\{day([-+0-9]*)\}\}': (p, match, content) ->
        d = (new Date())
        unless content[0] in ['-', '+']
          return d.toLocaleString(p.config.locale, p.config.formats.day)

        relativeDays = parseInt(content)
        d.setDate(d.getDate() + relativeDays)
        d.toLocaleString(p.config.locale, p.config.formats.day)

      '\{\{day-name([-+0-9]*)\}\}': (p, match, content) ->
        d = (new Date())
        unless content[0] in ['-', '+']
          return d.toLocaleString(p.config.locale, p.config.formats.dayName)

        relativeDays = parseInt(content)
        d.setDate(d.getDate() + relativeDays)
        d.toLocaleString(p.config.locale, p.config.formats.dayName)

      '\{\{time\}\}': (p, match, content) ->
        (new Date()).toLocaleTimeString(p.config.locale)

  init: =>
    @slides.each(@_doWithSlide)

  makeRegexp: (mapping) ->
    unless mapping of DynamicDate.cache
      DynamicDate.cache[mapping] = new RegExp("#{mapping}", 'g')

    DynamicDate.cache[mapping]

  _doWithSlide: (index, slide) =>
    $elements = $(@config.selector, slide)
    $elements.each(@_doWithElement)

  _doWithElement: (index, element) =>
    $element = $(element)
    html     = $element.html()
    replaced = false
    for mapping, callback of @config.mappings
      regexp = @makeRegexp(mapping)
      html = html.replace(regexp, (match, contents, offset, input_string) =>
        replaced = true
        callback(@, match, contents)
      )

    $element.html(html) if replaced
