class @AnswerClick extends AbstractFormsliderPlugin
  @config:
    resetAnswerOnGoingBack: false

  init: =>
    @container.on('mouseup', @config.answerSelector, @onAnswerClicked)
    if @config.resetAnswerOnGoingBack
      @on('before.prev', @resetAnswersOnGoingBack)

  resetAnswersOnGoingBack: (event, current, direction, next) =>
    $slide  = $(next)
    return if $slide.hasClass('multiple-answers')

    $answer          = $(event.currentTarget)
    $allAnswersinRow = $(@config.answerSelector, $slide)
    $allAnswersinRow.removeClass(@config.answerSelectedClass)


  onAnswerClicked: (event) =>
    event.preventDefault()

    $answer = $(event.currentTarget)
    $slide  = $(@slideByIndex())

    if $slide.hasClass('multiple-answers')
      $answer.toggleClass(@config.answerSelectedClass)

    else
      $answerRow       = $answer.closest(@config.answersSelector)
      $allAnswersinRow = $(@config.answerSelector, $answerRow)
      $otherAnswers    = $allAnswersinRow.not($answer)

      $allAnswersinRow.removeClass(@config.answerSelectedClass)
      $answer.addClass(@config.answerSelectedClass)
      $('input[type="checkbox"]', $otherAnswers).prop("checked", false)

    $questionInput = $(@config.questionSelector, $slide)
    $answerInput   = $('input', $answer)

    # fix safari ios issue when click on label
    if $answerInput.is(':radio') || $answerInput.is(':checkbox')
      $answerInput.click()

    @trigger('question-answered',
      $questionInput.prop('id'),
      $answerInput.prop('id'),
      $answerInput.val(),
      @index(),
      $slide.hasClass('multiple-answers'),
      $answer.hasClass(@config.answerSelectedClass),
      $answerInput
    )
