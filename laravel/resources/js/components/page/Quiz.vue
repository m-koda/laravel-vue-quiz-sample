<template>
  <div>
    <main>
      <div class="container">
        <article class="col-md-8 col-xs-12">
          <section>
            <h2 class="quiz-question-h2">
              <img class="quiz-question__logo" src="/images/what-is-mark.png" />
              第{{ quizNumber }}問
            </h2>
            <p>{{ title }}</p>
            <div v-if="imageSrc">
              <img class="img-responsive" id="quiz-image" v-bind:src="'/images/quiz/' + imageSrc" />
            </div>
            <div class="quiz-answer__list">
              <ul>
                <li v-for="(answer, index) in answers" v-bind:key="index">
                  <a>
                    <button
                      v-on:click="goAnswer(index + 1)"
                      v-bind:disabled="isAlreadyAnswered"
                    >{{ index + 1 }}</button>
                  </a>
                  {{ answer }}
                </li>
              </ul>
            </div>
            <div class="text-right">カテゴリー： {{ categoryName }}</div>
          </section>
          <section>
            <h2 class="quiz-correct-h2">
              <img class="quiz-correct__logo" src="/images/correct-mark.png" />正解
            </h2>
            <p>
              <button
                class="quiz-correct-answer"
                v-show="isAlreadyAnswered"
                disabled
              >{{ correctAnswerNo }}</button>
            </p>
            <button v-on:click="goAnswer(0)" v-show="!isAlreadyAnswered">正解を表示する</button>
            <div class="alert alert-info" v-show="isCorrect">
              <strong>正解!</strong>
            </div>
            <div class="alert alert-danger" v-show="isMistake">
              <strong>不正解!</strong>
            </div>
          </section>
          <section>
            <h2 class="quiz-commentary-h2">
              <img class="quiz-commentary__logo" src="/images/commentary-mark.png" />解説
            </h2>
            <div
              class="quiz-commentary__text"
              v-show="isAlreadyAnswered"
              style="white-space:pre-wrap; word-wrap:break-word;"
            >{{ commentary }}</div>
            <button
              type="button"
              class="btn btn-primary center-block"
              v-on:click="goNextQuiz"
              v-if="!isQuizFinish"
            >次の問題へ</button>
            <button
              type="button"
              class="center-block"
              data-toggle="modal"
              data-target="#modal-result"
              v-if="isQuizFinish"
              v-on:click="showResult"
            >結果を見る</button>
          </section>
        </article>

        <the-sidebar></the-sidebar>
      </div>
    </main>

    <the-modal :correctPercentageObject="correctPercentageObject" ref="modal"></the-modal>
  </div>
</template>

<script>
import TheSidebar from "../layout/TheSidebar";
import TheModal from "../module/TheModal";

export default {
  components: {
    TheSidebar,
    TheModal
  },
  data() {
    return {
      quizData: [],
      title: "",
      imageSrc: "",
      answers: [],
      commentary: "",
      correctAnswerNo: 0,
      isCorrect: false,
      isMistake: false,
      isAlreadyAnswered: false,
      isQuizFinish: false,
      score: 0,
      quizNumber: 1,
      categoryName: "",
      correctPercentageObject: {}
    };
  },
  mounted() {
    // クイズの取得
    const categories = this.$route.query.categories;
    const loader = this.$loading.show();
    this.$http.get(`/api/quiz?categories=${categories}`).then(response => {
      this.quizData = response.data;
      this.findNextQuiz(0);
      loader.hide();
    });
  },
  methods: {
    findNextQuiz(quizNumber) {
      this.title = this.quizData[quizNumber].title;
      this.answers = [
        this.quizData[quizNumber].answer.answer_1,
        this.quizData[quizNumber].answer.answer_2,
        this.quizData[quizNumber].answer.answer_3,
        this.quizData[quizNumber].answer.answer_4
      ];
      this.commentary = this.quizData[quizNumber].answer.commentary;
      this.correctAnswerNo = this.quizData[quizNumber].answer.correct_answer_no;
      this.categoryName = this.quizData[quizNumber].category.name;
    },
    goAnswer(answerNum) {
      if (answerNum === 0) {
        // 正解を表示するの場合
        this.isCorrect = false;
        this.isMistake = false;
      } else if (answerNum === Number(this.correctAnswerNo)) {
        // 正解の場合
        this.isCorrect = true;
        this.isMistake = false;
        this.score++;
      } else {
        // 不正解の場合
        this.isCorrect = false;
        this.isMistake = true;
      }
      this.isAlreadyAnswered = true;

      if (this.quizNumber >= 5) {
        this.endQuiz();
      }
    },
    goNextQuiz() {
      if (this.quizNumber >= 5) {
        this.endQuiz();
      } else {
        this.findNextQuiz(this.quizNumber);
        this.quizNumber++;
        this.isCorrect = false;
        this.isMistake = false;
        this.isAlreadyAnswered = false;
      }
    },
    showResult() {
      this.$refs.modal.render();
    },
    endQuiz() {
      this.isQuizFinish = true;
      this.answerNo = "-";
      this.isAlreadyAnswered = true;
      this.correctPercentageObject = {
        correctScore: this.score,
        mistakeScore: 5 - this.score
      };
    }
  }
};
</script>