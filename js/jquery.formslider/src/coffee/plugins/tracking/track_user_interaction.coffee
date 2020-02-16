class @TrackUserInteraction extends AbstractFormsliderPlugin
  @config:
    questionAnsweredEvent: 'question-answered'
    trackSlideIndexEntered: true
    trackSlideRoleEntered: true
    trackSlideIdEntered: true
    trackQuestionIdWithAnswer: true
    trackQuestionAnsweredWithAnswer: true
    trackAnswerNameWithAnswer: true
    trackValidZipcodeEntered: true

  init: =>
    @setupQuestionAnswerTracking()
    @setupTransportTracking()
    if @config.trackValidZipcodeEntered
      @on('validation.valid.zipcode': (plugin, event, slide) ->
        plugin.track('userinput-zipcode', $('input', slide).val())
      )

  setupTransportTracking: =>
    @on("after", (event, currentSlide, direction, prevSlide) =>
      role  = $(currentSlide).data('role')
      id    = $(currentSlide).data('id')

      if @config.trackSlideIndexEntered
        @track("slide-#{@index()}-entered",  direction)

      if @config.trackSlideRoleEntered
        @track("slide-role-#{role}-entered", direction)

      if @config.trackSlideIdEntered
        @track("slide-id-#{id}-entered",     direction) if id
    )

  setupQuestionAnswerTracking: =>
    # coffeelint: disable
    @on('question-answered', (event, questionId, answerId, value, slideIndex, multiple, selected, $input) =>
      eventName = @config.questionAnsweredEvent

      if @config.trackQuestionAnsweredSlideIndex
        @track(eventName, slideIndex)

      possibleLeadValue = $input.data('answer-weight')
      if @config.trackQuestionIdWithAnswer
        name = questionId
        @track(name, "#{name}=#{value}", null, possibleLeadValue)

      if @config.trackAnswerNameWithAnswer
        name = $input.prop('name')
        @track(name, "#{name}=#{value}", null, possibleLeadValue)

    )
    # coffeelint: enable
