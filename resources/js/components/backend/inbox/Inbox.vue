<template>
  <div>
    <md-card>
      <md-card-header>
        <span class="md-title">Inbox</span>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <div class="menu">
          <md-list class="md-triple-line md-dense">
            <md-list-item>
              <md-avatar>
                <img src="https://placeimg.com/40/40/people/1" alt="People" />
              </md-avatar>

              <div class="md-list-item-text">
                <span>Ali Connors</span>
                <span>Brunch this weekend?</span>
                <p>
                  I'll be in your neighborhood doing errands this week. Do you want to
                  meet?
                </p>
              </div>

              <md-button class="md-icon-button md-list-action">
                <md-icon class="md-primary">star</md-icon>
              </md-button>
            </md-list-item>

            <md-divider class="md-inset"></md-divider>

            <md-list-item>
              <md-avatar>
                <img src="https://placeimg.com/40/40/people/6" alt="People" />
              </md-avatar>

              <div class="md-list-item-text">
                <span>me, Scott, Jennifer</span>
                <span>Summer BBQ</span>
                <p>Wish I could come, but I'm out of town this week. :(</p>
              </div>

              <md-button class="md-icon-button md-list-action">
                <md-icon>star_border</md-icon>
              </md-button>
            </md-list-item>

            <md-divider class="md-inset"></md-divider>

            <md-list-item>
              <md-avatar>
                <img src="https://placeimg.com/40/40/people/5" alt="People" />
              </md-avatar>

              <div class="md-list-item-text">
                <span>Sandra Adams</span>
                <span>Oui oui</span>
                <p>Do you have Paris recommendations? Have you visited good places?</p>
              </div>

              <md-button class="md-icon-button md-list-action">
                <md-icon>star_border</md-icon>
              </md-button>
            </md-list-item>

            <md-divider class="md-inset"></md-divider>

            <md-list-item>
              <md-avatar>
                <img src="https://placeimg.com/40/40/people/8" alt="People" />
              </md-avatar>

              <div class="md-list-item-text">
                <span>Trevor Hansen</span>
                <span>Order confirmation</span>
                <p>Thank you for your recent order from Amazon</p>
              </div>

              <md-button class="md-icon-button md-list-action">
                <md-icon>star_border</md-icon>
              </md-button>
            </md-list-item>
          </md-list>
        </div>
        <div class="content">right</div>
      </md-card-content>
    </md-card>
  </div>
</template>
<style lang="scss" scoped>
.md-card {
  .md-card-content {
    display: flex;
    justify-content: space-between;
    .menu {
      flex: 1;
      max-width: 300px;
      border-right: solid 1px #ddd;
      .md-list-item:hover {
        cursor: pointer;
        background: #ffa50021;
      }
    }
    .content {
      padding: 20px;
      flex: 9;
    }
  }
}
</style>
