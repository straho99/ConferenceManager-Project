namespace ConferenceManager.MySqlConsole
{
    using System;
    using System.Collections.Generic;
    using System.Linq;
    using System.Text;
    using System.Threading.Tasks;

    using ConferenceManager.MySqlData;
    using ConferenceManager.Models;

    public class ConferenceManagerMySqlConsole
    {
        private static MySqlConferenceManagerContext dbContext = new MySqlConferenceManagerContext();

        public static void Main()
        {
            //CreateUser("strahil", "Strahil Ruychev");
            //CreateUser("ivan", "Ivan Petrov");
            //CreateUser("evlogi", "Evlogi Temelkov");
            //CreateUser("milena", "Milena Zdravkova");
            //CreateUser("anelia", "Anelia Nikolova");

            //CreateVenue(
            //    "NDK",
            //    "Very big and ugly convention centre, a relique from the comunist past. Cheap to rent though...",
            //    "Sofia, Bulgaria",
            //    "ivan");
            //CreateVenue(
            //    "InterExpoCenter",
            //    "Modern and well equipped convention centres. Has metro station nearby.",
            //    "Tsarigradsko Shausse, Sofia, Bulgaria",
            //    "evlogi");
            //CreateVenue(
            //    "SofiaExpoCenter",
            //    "The newest convention centre in Sofia. Has the best equipement and fascilities.",
            //    "Paradise Centre Mall, Sofia, Bulgaria",
            //    "milena");
            //CreateVenue(
            //    "Interpred",
            //    "Somewhat old, but still popular convention centre. Big halls, appropriate for large events.",
            //    "Dragan Tsankov blvd., Sofia, Bulgaria",
            //    "milena");

            //CreateHall(
            //    "Hall 1",
            //    2500,
            //    "NDK");
            //CreateHall(
            //    "Hall 2",
            //    1000,
            //    "NDK");
            //CreateHall(
            //    "Hall 3",
            //    500,
            //    "NDK");

            //CreateHall(
            //    "Rodina",
            //    100,
            //    "Interpred");
            //CreateHall(
            //    "Republika",
            //    20,
            //    "Interpred");
            //CreateHall(
            //    "Stara Planina",
            //    53,
            //    "Interpred");

            //CreateHall(
            //    "London",
            //    121,
            //    "SofiaExpoCenter");
            //CreateHall(
            //    "Paris",
            //    11,
            //    "SofiaExpoCenter");
            //CreateHall(
            //    "Lubljana",
            //    77,
            //    "SofiaExpoCenter");

            //CreateHall(
            //    "Danube",
            //    45,
            //    "InterExpoCenter");
            //CreateHall(
            //    "Nile",
            //    53,
            //    "InterExpoCenter");
            //CreateHall(
            //    "Amazon",
            //    20,
            //    "InterExpoCenter");

            //CreateConference(
            //    "PHP 7 - the good, the bad and the evil",
            //    DateTime.Now.AddDays(20),
            //    DateTime.Now.AddDays(23),
            //    "milena"
            //    );
            //CreateConference(
            //    "Android World Devs Conference",
            //    DateTime.Now.AddDays(25),
            //    DateTime.Now.AddDays(30),
            //    "strahil"
            //    );
            //CreateConference(
            //    "ASP.Net Web Development - the future",
            //    DateTime.Now.AddDays(30),
            //    DateTime.Now.AddDays(34),
            //    "ivan"
            //    );

            //AddVenueRequestForConference(1, "NDK");
            //AddVenueRequestForConference(2, "InterExpoCenter");
            //AddVenueRequestForConference(3, "SofiaExpoCenter");

            //var phpConference = dbContext.Conferences.Find(1);
            //AddLectureToConference(
            //    phpConference, 
            //    "What's new in PHP 7", 
            //    phpConference.StartDate.AddHours(9), 
            //    phpConference.StartDate.AddHours(12));
            //AddLectureToConference(
            //    phpConference,
            //    "PHP 7 Speed Improvements",
            //    phpConference.StartDate.AddHours(13),
            //    phpConference.StartDate.AddHours(15));
            //AddLectureToConference(
            //    phpConference,
            //    "PHP 7 Strict Types",
            //    phpConference.StartDate.AddHours(10),
            //    phpConference.StartDate.AddHours(13));
        }

        private static void CreateUser(string username, string fullName)
        {
            var user = new User()
            {
                Username = username,
                FullName = fullName,
                Email = username + "@mail.bg",
                PasswordHash = "123456",
                Telephone = "+359 2 12345678"
            };
            dbContext.Users.Add(user);
            dbContext.SaveChanges();
        }

        private static void CreateVenue(string name, string description, string address, string owner)
        {
            var venue = new Venue()
            {
                Name = name,
                Description = description,
                Address = address,
                Owner = dbContext.Users.FirstOrDefault(u => u.Username == owner),
            };
            dbContext.Venues.Add(venue);
            dbContext.SaveChanges();
        }

        private static void CreateHall(string name, int capacity, string venue)
        {
            var hall = new Hall()
            {
                Name = name,
                Capacity = capacity,
                Venue = dbContext.Venues.FirstOrDefault(u => u.Name == venue),
            };
            dbContext.Halls.Add(hall);
            dbContext.SaveChanges();
        }

        private static void CreateConference(string name, DateTime startDate, DateTime endDate, string owner)
        {
            var conference = new Conference()
            {
                Name = name,
                StartDate = startDate,
                EndDate = endDate,
                Owner = dbContext.Users.FirstOrDefault(u => u.Username == owner),
            };
            dbContext.Conferences.Add(conference);
            dbContext.SaveChanges();
        }

        private static void AddVenueRequestForConference(int conferenceId, string venue)
        {
            var conference = dbContext.Conferences.Find(conferenceId);
            var dbVenue = dbContext.Venues.FirstOrDefault(v => v.Name == venue);
            var request = new VenueReservationRequest()
            {
                Conference = conference,
                Venue = dbVenue,
                Status = RequestStatus.Pending,
            };
            conference.Venue = dbVenue;
            dbContext.VenueReservationRequests.Add(request);
            dbContext.SaveChanges();
        }

        private static void AddLectureToConference(Conference conference, string title, DateTime start, DateTime end)
        {
            var lecture = new Lecture()
            {
                Title = title,
                Description = "Lecture description goes here...",
                Conference = conference,
                StartDate = start,
                EndDate = end,
            };
            dbContext.Lectures.Add(lecture);
            dbContext.SaveChanges();
        }
    }
}
