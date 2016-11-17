//var fake_user_data = {
//    user: {
//      name: randomChoice(['Cruz Welborn']),
//      url: randomChoice(['images/github.jpg','images/twitter.jpg','images/linkedin.jpg', false]),
//      clout_id: 'CT' + getRandomInt(10000000000, 99999999999),
//      notification_colors: randomChoice(['blue', 'purple', 'both', false])
//    },
//    store: {
//        score: getRandomInt(0, 1000),
//        in_store_spending: getRandomPercent(),
//        competitor_spending: getRandomPercent(),
//        category_spending: getRandomPercent(),
//        related_spending: getRandomPercent(),
//        overall_spending: getRandomPercent(),
//        linked_account: getRandomPercent(),
//        activity: getRandomPercent(),
//    },
//    customer_details: {
//      city: randomChoice(['Los Angeles', 'New York', 'Washington', 'Seattle']),
//      state: randomChoice(['CA', 'NY', 'DC', 'WA']),
//      zip: getRandomInt(10000, 99999),
//      country: 'USA',
//      gender: randomChoice(['M', 'F']),
//      age: getRandomInt(18, 60),
//      custom_label: randomChoice(['Favorite Customer', 'Shareholder', 'Celebrity', 'Influencer']),
//      notes: randomChoice(['Seating Priority! Treat as VIP', 'He/She likes champagne', 'VIP customer and big network', '']),
//      priority: randomChoice(['High: Big Spender', 'High: new Customer', 'Normal: Customer', 'Enrolled via "VIP Sign In With Clout"']),
//      network: getRandomInt(1, 100000),
//      invites: getRandomInt(100, 1000000),
//    },
//    reservations: {
//      upcoming: new Date().toLocaleString(),
//      time: '8:30PM',
//      type: randomChoice(['Event', 'Private Shopping Experience', 'Hotel Room', 'Table']),
//      size: getRandomInt(1, 10),
//      status: randomChoice(['pending', 'approved', 'cancelled']),
//      action: randomChoice([true, false]),
//      other_reservations: getRandomInt(0, 10),
//    },
//    activity: {
//      last_checkin: randomChoice(['In Store Now! 3:35pm PST', '10:30am PST', '6:06pm EST', '1:37pm EST', '8:30pm PST']),
//      past_checkins: getRandomInt(0, 150),
//      transactions: getRandomInt(1, 50),
//      reviews: getRandomInt(0, 7),
//      favorited: randomChoice([true, false]),
//    },
//    promotions: {
//      available: getRandomInt(0, 10),
//      viewed: getRandomInt(0, 5),
//      used: getRandomInt(0, 5),
//      promotional_spending: {
//        lifetime: getRandomInt(1000, 1000000),
//        this_week: getRandomInt(5, 100),
//        last_week: getRandomInt(5, 100),
//        this_month: getRandomInt(50, 10000),
//        last_month: getRandomInt(50, 10000),
//        this_year: getRandomInt(500, 100000),
//        last_year: getRandomInt(500, 100000)
//      }
//    },
//    spending: {
//      store: {
//        lifetime: getRandomInt(1000, 1000000),
//        this_week: getRandomInt(5, 100),
//        last_week: getRandomInt(5, 100),
//        this_month: getRandomInt(50, 10000),
//        last_month: getRandomInt(50, 10000),
//        this_year: getRandomInt(500, 100000),
//        last_year: getRandomInt(500, 100000)
//      },
//      competitors: {
//        all: getRandomInt(1000, 1000000),
//        1: getRandomInt(1000, 1000000)
//      },
//      category: {
//        all: getRandomInt(1000, 1000000),
//        1: getRandomInt(1000, 1000000)
//      }
//    }
//}
//
//
//function getRandomInt(min, max) {
//    return Math.floor(Math.random() * (max - min + 1)) + min;
//}
//
//function getRandomPercent() {
// return getRandomInt(0, 100) / 100
//}
//
//function randomChoice(items) {
//  return items[Math.floor(Math.random()*items.length)]
//}
