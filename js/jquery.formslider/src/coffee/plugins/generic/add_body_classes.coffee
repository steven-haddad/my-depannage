class @AddBodyClasses extends AbstractFormsliderPlugin
  @config =
    'prefix': 'sv-slider'

  init: =>
    @body = $('body')
    @on('ready', @initBodyClass)
    @on('before', @updateBodyClass)

  initBodyClass: =>
    $currentSlide = $(@slideByIndex())
    role = "#{@config.prefix}-role-#{$currentSlide.data('role')}"
    @lastClasses = "#{role} #{role}-#{$currentSlide.data('index')}"
    @body.addClass(@lastClasses)

  updateBodyClass: (event, current, direction, next) =>
    @body.removeClass(@lastClasses)

    $currentSlide = $(next)
    role = "#{@config.prefix}-role-#{$currentSlide.data('role')}"
    @lastClasses = "#{role} #{role}-#{$currentSlide.data('index')}"

    @body.addClass(@lastClasses)
